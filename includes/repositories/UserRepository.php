<?php

require_once __DIR__ . '/../core/BaseRepository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends BaseRepository
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE email = ?";
        $params = [$email];
        
        if ($excludeId !== null) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $result = $this->db->fetch($sql, $params);
        return (int) $result['count'] > 0;
    }

    public function findAdmins(): array
    {
        return $this->findBy(['role' => 'admin']);
    }

    public function findRegularUsers(): array
    {
        return $this->findBy(['role' => 'user']);
    }

    public function createUser(array $data): int
    {
        $insertData = [];
        
        if (isset($data['emri']) && isset($data['mbiemri'])) {
            $insertData['full_name'] = trim($data['emri'] . ' ' . $data['mbiemri']);
        } elseif (isset($data['full_name'])) {
            $insertData['full_name'] = $data['full_name'];
        }
        
        if (isset($data['email'])) {
            $insertData['email'] = $data['email'];
        }
        
        if (isset($data['password'])) {
            $insertData['PASSWORD'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        if (isset($data['role'])) {
            $insertData['role'] = $data['role'];
        }
        
        return $this->insert($insertData);
    }

    public function updatePassword(int $id, string $newPassword): bool
    {
        return $this->update($id, [
            'PASSWORD' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);
    }

    public function verifyPassword(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if ($user) {
            $storedPassword = $user['PASSWORD'] ?? $user['password'] ?? '';
            if (password_verify($password, $storedPassword)) {
                return $user;
            }
        }
        return null;
    }
}
