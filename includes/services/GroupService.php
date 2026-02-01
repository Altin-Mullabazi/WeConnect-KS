<?php

require_once __DIR__ . '/../repositories/GroupRepository.php';
require_once __DIR__ . '/../core/Validator.php';

class GroupService
{
    private GroupRepository $groupRepo;

    public function __construct()
    {
        $this->groupRepo = new GroupRepository();
    }

    public function create(array $data): array
    {
        $validator = new Validator($data);
        $validator
            ->required('groupName', 'Emri i grupit është i detyrueshëm.')
            ->required('groupCategory', 'Kategoria është e detyrueshme.')
            ->required('groupLocation', 'Vendndodhja është e detyrueshme.')
            ->required('groupDescription', 'Përshkrimi është i detyrueshëm.');

        if (!$validator->isValid()) {
            return ['success' => false, 'error' => $validator->getFirstError()];
        }

        $groupId = $this->groupRepo->insert([
            'name' => Validator::sanitize($data['groupName']),
            'category' => Validator::sanitize($data['groupCategory']),
            'location' => Validator::sanitize($data['groupLocation']),
            'description' => Validator::sanitize($data['groupDescription']),
            'image' => Validator::sanitize($data['groupImage'] ?? ''),
            'creator_id' => $data['creator_id'] ?? 0,
            'members_count' => 1
        ]);

        return ['success' => true, 'group_id' => $groupId];
    }

    public function delete(int $id): array
    {
        $group = $this->groupRepo->findById($id);
        if (!$group) {
            return ['success' => false, 'error' => 'Grupi nuk u gjet.'];
        }

        $this->groupRepo->delete($id);
        return ['success' => true];
    }

    public function getById(int $id): ?array
    {
        return $this->groupRepo->findById($id);
    }

    public function getAll(): array
    {
        return $this->groupRepo->findAll();
    }

    public function getLatest(int $limit = 10): array
    {
        return $this->groupRepo->getLatest($limit);
    }

    public function search(string $term): array
    {
        return $this->groupRepo->search($term);
    }
}
