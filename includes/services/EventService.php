<?php

require_once __DIR__ . '/../repositories/EventRepository.php';
require_once __DIR__ . '/../core/Validator.php';
require_once __DIR__ . '/UploadService.php';

class EventService
{
    private EventRepository $eventRepo;
    private UploadService $uploadService;

    public function __construct()
    {
        $this->eventRepo = new EventRepository();
        $this->uploadService = new UploadService('uploads/events/');
    }

    public function create(array $data, ?array $imageFile = null): array
    {
        $validator = new Validator($data);
        $validator
            ->required('title', 'Titulli është i detyrueshëm.')
            ->required('description', 'Përshkrimi është i detyrueshëm.')
            ->required('event_date', 'Data e eventit është e detyrueshme.')
            ->required('event_time', 'Ora e eventit është e detyrueshme.')
            ->required('location', 'Lokacioni është i detyrueshëm.')
            ->date('event_date');

        if (!$validator->isValid()) {
            return ['success' => false, 'error' => $validator->getFirstError()];
        }

        $imagePath = null;
        if ($imageFile && !empty($imageFile['tmp_name'])) {
            $uploadResult = $this->uploadService->upload($imageFile);
            if (!$uploadResult['success']) {
                return $uploadResult;
            }
            $imagePath = 'uploads/events/' . $uploadResult['filename'];
        }

        $eventDateTime = $data['event_date'];
        if (!empty($data['event_time'])) {
            $eventDateTime = $data['event_date'] . ' ' . $data['event_time'];
        }
        
        $eventId = $this->eventRepo->insert([
            'title' => Validator::sanitize($data['title']),
            'description' => Validator::sanitize($data['description']),
            'image' => $imagePath,
            'event_date' => $eventDateTime,
            'location' => Validator::sanitize($data['location']),
            'category' => Validator::sanitize($data['category'] ?? ''),
            'organizer_id' => $data['user_id'] ?? 0
        ]);

        return ['success' => true, 'event_id' => $eventId];
    }

    public function update(int $id, array $data, ?array $imageFile = null): array
    {
        $event = $this->eventRepo->findById($id);
        if (!$event) {
            return ['success' => false, 'error' => 'Eventi nuk u gjet.'];
        }

        $validator = new Validator($data);
        $validator
            ->required('title', 'Titulli është i detyrueshëm.')
            ->required('description', 'Përshkrimi është i detyrueshëm.')
            ->required('event_date', 'Data e eventit është e detyrueshme.')
            ->required('event_time', 'Ora e eventit është e detyrueshme.')
            ->required('location', 'Lokacioni është i detyrueshëm.');

        if (!$validator->isValid()) {
            return ['success' => false, 'error' => $validator->getFirstError()];
        }

        $eventDateTime = $data['event_date'];
        if (!empty($data['event_time'])) {
            $eventDateTime = $data['event_date'] . ' ' . $data['event_time'];
        }
        
        $updateData = [
            'title' => Validator::sanitize($data['title']),
            'description' => Validator::sanitize($data['description']),
            'event_date' => $eventDateTime,
            'location' => Validator::sanitize($data['location']),
            'category' => Validator::sanitize($data['category'] ?? '')
        ];

        if ($imageFile && !empty($imageFile['tmp_name'])) {
            $uploadResult = $this->uploadService->upload($imageFile);
            if (!$uploadResult['success']) {
                return $uploadResult;
            }
            if ($event['image']) {
                $oldFilename = basename($event['image']);
                $this->uploadService->delete($oldFilename);
            }
            $updateData['image'] = 'uploads/events/' . $uploadResult['filename'];
        }

        $this->eventRepo->update($id, $updateData);
        return ['success' => true];
    }

    public function delete(int $id): array
    {
        $event = $this->eventRepo->findById($id);
        if (!$event) {
            return ['success' => false, 'error' => 'Eventi nuk u gjet.'];
        }

        if ($event['image']) {
            $oldFilename = basename($event['image']);
            $this->uploadService->delete($oldFilename);
        }

        $this->eventRepo->delete($id);
        return ['success' => true];
    }

    public function getById(int $id): ?array
    {
        return $this->eventRepo->findById($id);
    }

    public function getAll(): array
    {
        return $this->eventRepo->findAll();
    }

    public function getUpcoming(int $limit = 10): array
    {
        return $this->eventRepo->findUpcoming($limit);
    }

    public function getLatest(int $limit = 5): array
    {
        return $this->eventRepo->getLatest($limit);
    }

    public function search(string $term): array
    {
        return $this->eventRepo->search($term);
    }

    public function getByCategory(string $category): array
    {
        return $this->eventRepo->findByCategory($category);
    }

    public function getCategories(): array
    {
        return $this->eventRepo->getCategories();
    }
}
