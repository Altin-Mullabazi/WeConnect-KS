<?php

require_once __DIR__ . '/../repositories/ProductRepository.php';
require_once __DIR__ . '/../core/Validator.php';
require_once __DIR__ . '/UploadService.php';

class ProductService
{
    private ProductRepository $productRepo;
    private UploadService $uploadService;

    public function __construct()
    {
        $this->productRepo = new ProductRepository();
        $this->uploadService = new UploadService('uploads/products/');
    }

    public function create(array $data, ?array $imageFile = null): array
    {
        $validator = new Validator($data);
        $validator
            ->required('name', 'Emri i produktit është i detyrueshëm.')
            ->required('description', 'Përshkrimi është i detyrueshëm.')
            ->required('price', 'Çmimi është i detyrueshëm.')
            ->numeric('price', 'Çmimi duhet të jetë numër.')
            ->positive('price', 'Çmimi duhet të jetë pozitiv.');

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

        $productId = $this->productRepo->insert([
            'name' => Validator::sanitize($data['name']),
            'description' => Validator::sanitize($data['description']),
            'price' => (float) $data['price'],
            'image' => $imagePath,
            'category' => Validator::sanitize($data['category'] ?? ''),
            'user_id' => $data['user_id'] ?? 0
        ]);

        return ['success' => true, 'product_id' => $productId];
    }

    public function update(int $id, array $data, ?array $imageFile = null): array
    {
        $product = $this->productRepo->findById($id);
        if (!$product) {
            return ['success' => false, 'error' => 'Produkti nuk u gjet.'];
        }

        $validator = new Validator($data);
        $validator
            ->required('name', 'Emri i produktit është i detyrueshëm.')
            ->required('description', 'Përshkrimi është i detyrueshëm.')
            ->required('price', 'Çmimi është i detyrueshëm.')
            ->numeric('price', 'Çmimi duhet të jetë numër.')
            ->positive('price', 'Çmimi duhet të jetë pozitiv.');

        if (!$validator->isValid()) {
            return ['success' => false, 'error' => $validator->getFirstError()];
        }

        $updateData = [
            'name' => Validator::sanitize($data['name']),
            'description' => Validator::sanitize($data['description']),
            'price' => (float) $data['price'],
            'category' => Validator::sanitize($data['category'] ?? '')
        ];

        if ($imageFile && !empty($imageFile['tmp_name'])) {
            $uploadResult = $this->uploadService->upload($imageFile);
            if (!$uploadResult['success']) {
                return $uploadResult;
            }
            if ($product['image']) {
                $this->uploadService->delete($product['image']);
            }
            $updateData['image'] = $uploadResult['filename'];
        }

        $this->productRepo->update($id, $updateData);
        return ['success' => true];
    }

    public function delete(int $id): array
    {
        $product = $this->productRepo->findById($id);
        if (!$product) {
            return ['success' => false, 'error' => 'Produkti nuk u gjet.'];
        }

        if ($product['image']) {
            $this->uploadService->delete($product['image']);
        }

        $this->productRepo->delete($id);
        return ['success' => true];
    }

    public function getById(int $id): ?array
    {
        return $this->productRepo->findById($id);
    }

    public function getAll(): array
    {
        return $this->productRepo->findAll();
    }

    public function getLatest(int $limit = 5): array
    {
        return $this->productRepo->getLatest($limit);
    }

    public function getPaginated(int $page = 1, int $perPage = 12): array
    {
        return $this->productRepo->getPaginated($page, $perPage);
    }

    public function search(string $term): array
    {
        return $this->productRepo->search($term);
    }

    public function getByCategory(string $category): array
    {
        return $this->productRepo->findByCategory($category);
    }

    public function getByPriceRange(float $min, float $max): array
    {
        return $this->productRepo->findByPriceRange($min, $max);
    }

    public function getCategories(): array
    {
        return $this->productRepo->getCategories();
    }

    public function getTotalCount(): int
    {
        return $this->productRepo->count();
    }
}
