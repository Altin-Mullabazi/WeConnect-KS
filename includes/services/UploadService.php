<?php

class UploadService
{
    private string $uploadDir;
    private array $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private int $maxSize = 5242880; // 5MB

    public function __construct(string $uploadDir = 'uploads/')
    {
        $this->uploadDir = rtrim($uploadDir, '/') . '/';
    }

    public function setAllowedTypes(array $types): self
    {
        $this->allowedTypes = $types;
        return $this;
    }

    public function setMaxSize(int $bytes): self
    {
        $this->maxSize = $bytes;
        return $this;
    }

    public function upload(array $file, ?string $customName = null): array
    {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return ['success' => false, 'error' => 'Nuk u ngarkua asnjë skedar.'];
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => $this->getUploadErrorMessage($file['error'])];
        }

        if ($file['size'] > $this->maxSize) {
            return ['success' => false, 'error' => 'Skedari është shumë i madh. Maksimumi: ' . $this->formatBytes($this->maxSize)];
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!in_array($mimeType, $this->allowedTypes)) {
            return ['success' => false, 'error' => 'Lloji i skedarit nuk lejohet.'];
        }

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }

        $extension = $this->getExtensionFromMime($mimeType);
        $filename = $customName ?? $this->generateUniqueFilename($extension);
        $destination = $this->uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ['success' => false, 'error' => 'Gabim gjatë ngarkimit të skedarit.'];
        }

        return [
            'success' => true,
            'filename' => $filename,
            'path' => $destination,
            'size' => $file['size'],
            'mime_type' => $mimeType
        ];
    }

    public function delete(string $filename): bool
    {
        $path = $this->uploadDir . $filename;
        if (file_exists($path)) {
            return unlink($path);
        }
        return false;
    }

    public function exists(string $filename): bool
    {
        return file_exists($this->uploadDir . $filename);
    }

    private function generateUniqueFilename(string $extension): string
    {
        return uniqid('img_', true) . '.' . $extension;
    }

    private function getExtensionFromMime(string $mimeType): string
    {
        $map = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
        ];
        return $map[$mimeType] ?? 'bin';
    }

    private function getUploadErrorMessage(int $error): string
    {
        $messages = [
            UPLOAD_ERR_INI_SIZE => 'Skedari tejkalon madhësinë maksimale të lejuar.',
            UPLOAD_ERR_FORM_SIZE => 'Skedari tejkalon madhësinë maksimale të formës.',
            UPLOAD_ERR_PARTIAL => 'Skedari u ngarkua pjesërisht.',
            UPLOAD_ERR_NO_FILE => 'Nuk u ngarkua asnjë skedar.',
            UPLOAD_ERR_NO_TMP_DIR => 'Mungon dosja e përkohshme.',
            UPLOAD_ERR_CANT_WRITE => 'Nuk mund të shkruhet skedari.',
            UPLOAD_ERR_EXTENSION => 'Ngarkimi u ndalua nga një ekstension.',
        ];
        return $messages[$error] ?? 'Gabim i panjohur gjatë ngarkimit.';
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }
        return round($bytes / 1024, 2) . ' KB';
    }
}
