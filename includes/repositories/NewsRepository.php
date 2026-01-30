<?php

require_once __DIR__ . '/../core/BaseRepository.php';
require_once __DIR__ . '/../models/News.php';

class NewsRepository extends BaseRepository
{
    protected string $table = 'news';

    public function findByCategory(string $category): array
    {
        return $this->findBy(['category' => $category]);
    }

    public function findByUser(int $userId): array
    {
        return $this->findBy(['user_id' => $userId]);
    }

    public function getLatest(int $limit = 5): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }

    public function search(string $term): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE title LIKE ? OR content LIKE ? ORDER BY created_at DESC";
        $searchTerm = "%$term%";
        return $this->db->fetchAll($sql, [$searchTerm, $searchTerm]);
    }

    public function getPaginated(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT ? OFFSET ?";
        return $this->db->fetchAll($sql, [$perPage, $offset]);
    }

    public function getCategories(): array
    {
        $sql = "SELECT DISTINCT category FROM {$this->table} WHERE category != '' ORDER BY category";
        $results = $this->db->fetchAll($sql);
        return array_column($results, 'category');
    }

    public function countByCategory(string $category): int
    {
        return $this->count(['category' => $category]);
    }
}
