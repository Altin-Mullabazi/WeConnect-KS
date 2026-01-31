<?php

require_once __DIR__ . '/../repositories/ContactRepository.php';
require_once __DIR__ . '/../core/Validator.php';

class ContactService
{
    private ContactRepository $contactRepo;

    public function __construct()
    {
        $this->contactRepo = new ContactRepository();
    }

    public function create(array $data): array
    {
        $validator = new Validator($data);
        $validator
            ->required('name', 'Emri është i detyrueshëm.')
            ->minLength('name', 2, 'Emri duhet të ketë së paku 2 karaktere.')
            ->maxLength('name', 100, 'Emri nuk mund të jetë më i gjatë se 100 karaktere.')
            ->required('email', 'Email-i është i detyrueshëm.')
            ->email('email', 'Email-i nuk është valid.')
            ->required('message', 'Mesazhi është i detyrueshëm.')
            ->minLength('message', 10, 'Mesazhi duhet të ketë së paku 10 karaktere.')
            ->maxLength('message', 2000, 'Mesazhi nuk mund të jetë më i gjatë se 2000 karaktere.');

        if (!$validator->isValid()) {
            return ['success' => false, 'message' => $validator->getFirstError()];
        }

        $contactId = $this->contactRepo->insert([
            'name' => Validator::sanitize($data['name']),
            'email' => Validator::sanitize($data['email']),
            'subject' => Validator::sanitize($data['subject'] ?? ''),
            'message' => Validator::sanitize($data['message'])
        ]);

        return ['success' => true, 'contact_id' => $contactId, 'message' => 'Mesazhi u ruajt me sukses!'];
    }

    public function getById(int $id): ?array
    {
        return $this->contactRepo->findById($id);
    }

    public function getAll(): array
    {
        return $this->contactRepo->findAll();
    }

    public function getLatest(int $limit = 10): array
    {
        return $this->contactRepo->getLatest($limit);
    }

    public function getPaginated(int $page = 1, int $perPage = 20): array
    {
        return $this->contactRepo->getPaginated($page, $perPage);
    }

    public function getTotalCount(): int
    {
        return $this->contactRepo->count();
    }
}



