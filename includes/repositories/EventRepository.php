<?php

require_once __DIR__ . '/../core/BaseRepository.php';
require_once __DIR__ . '/../models/Event.php';

class EventRepository extends BaseRepository
{
    protected string $table = 'events';

    public function findUpcoming(int $limit = 10): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE event_date >= CURDATE() ORDER BY event_date ASC, event_time ASC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }

    public function findPast(int $limit = 10): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE event_date < CURDATE() ORDER BY event_date DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }

    public function findByCategory(string $category): array
    {
        return $this->findBy(['category' => $category]);
    }

    public function findByUser(int $userId): array
    {
        return $this->findBy(['organizer_id' => $userId]);
    }

    public function findByDateRange(string $startDate, string $endDate): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE event_date BETWEEN ? AND ? ORDER BY event_date ASC";
        return $this->db->fetchAll($sql, [$startDate, $endDate]);
    }

    public function search(string $term): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE title LIKE ? OR description LIKE ? OR location LIKE ? ORDER BY event_date ASC";
        $searchTerm = "%$term%";
        return $this->db->fetchAll($sql, [$searchTerm, $searchTerm, $searchTerm]);
    }

    public function getLatest(int $limit = 5): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }

    public function countUpcoming(): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE event_date >= CURDATE()";
        $result = $this->db->fetch($sql);
        return (int) ($result['count'] ?? 0);
    }

    public function getCategories(): array
    {
        $sql = "SELECT DISTINCT category FROM {$this->table} WHERE category != '' ORDER BY category";
        $results = $this->db->fetchAll($sql);
        return array_column($results, 'category');
    }
}
