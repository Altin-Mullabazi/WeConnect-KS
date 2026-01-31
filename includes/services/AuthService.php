<?php

require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../core/Validator.php';

class AuthService
{
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function login(string $email, string $password): array
    {
        $validator = new Validator(['email' => $email, 'password' => $password]);
        $validator->required('email')->email('email')->required('password');

        if (!$validator->isValid()) {
            return ['success' => false, 'error' => $validator->getFirstError()];
        }

        $user = $this->userRepo->verifyPassword($email, $password);
        if (!$user) {
            return ['success' => false, 'error' => 'Email ose fjalëkalimi nuk është i saktë.'];
        }

        $this->startSession($user);
        return ['success' => true, 'user' => $user];
    }

    public function register(array $data): array
    {
        $validator = new Validator($data);
        $validator
            ->required('emri')
            ->required('mbiemri')
            ->required('email')
            ->email('email')
            ->required('password')
            ->minLength('password', 6, 'Fjalëkalimi duhet të ketë së paku 6 karaktere.')
            ->match('password', 'confirm_password', 'Fjalëkalimet nuk përputhen.');

        if (!$validator->isValid()) {
            return ['success' => false, 'error' => $validator->getFirstError()];
        }

        if ($this->userRepo->emailExists($data['email'])) {
            return ['success' => false, 'error' => 'Ky email është i regjistruar tashmë.'];
        }

        $userId = $this->userRepo->createUser([
            'emri' => Validator::sanitize($data['emri']),
            'mbiemri' => Validator::sanitize($data['mbiemri']),
            'email' => Validator::sanitize($data['email']),
            'password' => $data['password'],
            'role' => 'user'
        ]);

        return ['success' => true, 'user_id' => $userId];
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
    }

    public function isLoggedIn(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }

    public function isAdmin(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function getCurrentUser(): ?array
    {
        if (!$this->isLoggedIn()) {
            return null;
        }
        return $this->userRepo->findById($_SESSION['user_id']);
    }

    public function getCurrentUserId(): ?int
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['user_id'] ?? null;
    }

    public function requireLogin(string $redirectUrl = 'login.php'): void
    {
        if (!$this->isLoggedIn()) {
            header("Location: $redirectUrl");
            exit;
        }
    }

    public function requireAdmin(string $redirectUrl = 'index.php'): void
    {
        if (!$this->isAdmin()) {
            header("Location: $redirectUrl");
            exit;
        }
    }

    private function startSession(array $user): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['full_name'] = $user['full_name'] ?? '';
        $_SESSION['role'] = $user['role'] ?? 'user';
    }

    public function changePassword(int $userId, string $currentPassword, string $newPassword): array
    {
        $user = $this->userRepo->findById($userId);
        if (!$user) {
            return ['success' => false, 'error' => 'Përdoruesi nuk u gjet.'];
        }

        $storedPassword = $user['PASSWORD'] ?? $user['password'] ?? '';
        if (!password_verify($currentPassword, $storedPassword)) {
            return ['success' => false, 'error' => 'Fjalëkalimi aktual nuk është i saktë.'];
        }

        if (strlen($newPassword) < 6) {
            return ['success' => false, 'error' => 'Fjalëkalimi i ri duhet të ketë së paku 6 karaktere.'];
        }

        $this->userRepo->updatePassword($userId, $newPassword);
        return ['success' => true];
    }
}
