<?php

require_once __DIR__ . '/../repositories/NewsRepository.php';
require_once __DIR__ . '/../core/Validator.php';
require_once __DIR__ . '/UploadService.php';

class NewsService
{
    private NewsRepository $newsRepo;
    private UploadService $uploadService;

    public function __construct()
    {
        $this->newsRepo = new NewsRepository();
        $this->uploadService = new UploadService('uploads/news/');
    }

    public function create(array $data, ?array $imageFile = null, ?array $pdfFile = null): array
    {
        $validator = new Validator($data);
        $validator
            ->required('title', 'Titulli është i detyrueshëm.')
            ->required('content', 'Përmbajtja është e detyrueshme.');

        if (!$validator->isValid()) {
            return ['success' => false, 'error' => $validator->getFirstError()];
        }

        $imagePath = null;
        if ($imageFile && !empty($imageFile['tmp_name'])) {
            $uploadResult = $this->uploadService->upload($imageFile);
            if (!$uploadResult['success']) {
                return $uploadResult;
            }
            $imagePath = $uploadResult['filename'];
        }

        $pdfPath = null;
        if ($pdfFile && !empty($pdfFile['tmp_name'])) {
            $pdfUploadService = new UploadService('uploads/news/');
            $pdfUploadService->setAllowedTypes(['application/pdf']);
            $uploadResult = $pdfUploadService->upload($pdfFile);
            if (!$uploadResult['success']) {
                return $uploadResult;
            }
            $pdfPath = $uploadResult['filename'];
        }

        $newsId = $this->newsRepo->insert([
            'title' => Validator::sanitize($data['title']),
            'content' => $data['content'],
            'image' => $imagePath,
            'pdf_file' => $pdfPath,
            'category' => Validator::sanitize($data['category'] ?? ''),
            'user_id' => $data['user_id'] ?? 0
        ]);

        return ['success' => true, 'news_id' => $newsId];
    }

    public function update(int $id, array $data, ?array $imageFile = null, ?array $pdfFile = null): array
    {
        $news = $this->newsRepo->findById($id);
        if (!$news) {
            return ['success' => false, 'error' => 'Lajmi nuk u gjet.'];
        }

        $validator = new Validator($data);
        $validator
            ->required('title', 'Titulli është i detyrueshëm.')
            ->required('content', 'Përmbajtja është e detyrueshme.');

        if (!$validator->isValid()) {
            return ['success' => false, 'error' => $validator->getFirstError()];
        }

        $updateData = [
            'title' => Validator::sanitize($data['title']),
            'content' => $data['content'],
            'category' => Validator::sanitize($data['category'] ?? '')
        ];

        if ($imageFile && !empty($imageFile['tmp_name'])) {
            $uploadResult = $this->uploadService->upload($imageFile);
            if (!$uploadResult['success']) {
                return $uploadResult;
            }
            if ($news['image']) {
                $this->uploadService->delete($news['image']);
            }
            $updateData['image'] = $uploadResult['filename'];
        }

        if ($pdfFile && !empty($pdfFile['tmp_name'])) {
            $pdfUploadService = new UploadService('uploads/news/');
            $pdfUploadService->setAllowedTypes(['application/pdf']);
            $uploadResult = $pdfUploadService->upload($pdfFile);
            if (!$uploadResult['success']) {
                return $uploadResult;
            }
            if ($news['pdf_file']) {
                $pdfUploadService->delete($news['pdf_file']);
            }
            $updateData['pdf_file'] = $uploadResult['filename'];
        }

        $this->newsRepo->update($id, $updateData);
        return ['success' => true];
    }

    public function delete(int $id): array
    {
        $news = $this->newsRepo->findById($id);
        if (!$news) {
            return ['success' => false, 'error' => 'Lajmi nuk u gjet.'];
        }

        if ($news['image']) {
            $this->uploadService->delete($news['image']);
        }

        if ($news['pdf_file']) {
            $pdfUploadService = new UploadService('uploads/news/');
            $pdfUploadService->delete($news['pdf_file']);
        }

        $this->newsRepo->delete($id);
        return ['success' => true];
    }

    public function getById(int $id): ?array
    {
        return $this->newsRepo->findById($id);
    }

    public function getAll(): array
    {
        return $this->newsRepo->findAll();
    }

    public function getLatest(int $limit = 5): array
    {
        return $this->newsRepo->getLatest($limit);
    }

    public function getPaginated(int $page = 1, int $perPage = 10): array
    {
        return $this->newsRepo->getPaginated($page, $perPage);
    }

    public function search(string $term): array
    {
        return $this->newsRepo->search($term);
    }

    public function getByCategory(string $category): array
    {
        return $this->newsRepo->findByCategory($category);
    }

    public function getCategories(): array
    {
        return $this->newsRepo->getCategories();
    }

    public function getTotalCount(): int
    {
        return $this->newsRepo->count();
    }
}
