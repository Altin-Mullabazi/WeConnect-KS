<?php

require_once __DIR__ . '/../core/BaseRepository.php';

class GroupRepository extends BaseRepository
{
    protected string $table = 'groups_table';

    public function findByCategory(string $category): array
    {
        return $this->findBy(['category' => $category]);
    }

    public function findByLocation(string $location): array
    {
        return $this->findBy(['location' => $location]);
    }

    public function getLatest(int $limit = 10): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }

    public function search(string $term): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE name LIKE ? OR description LIKE ? ORDER BY created_at DESC";
        $searchTerm = "%$term%";
        return $this->db->fetchAll($sql, [$searchTerm, $searchTerm]);
    }
}
