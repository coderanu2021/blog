<?php
class ImageManager {
    private $uploadDir;
    private $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private $maxFileSize = 5242880; // 5MB

    public function __construct($uploadDir = '../uploads/') {
        $this->uploadDir = $uploadDir;
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function uploadImage($file, $type = 'blog') {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return ['success' => false, 'message' => 'No file uploaded'];
        }

        if (!in_array($file['type'], $this->allowedTypes)) {
            return ['success' => false, 'message' => 'Invalid file type'];
        }

        if ($file['size'] > $this->maxFileSize) {
            return ['success' => false, 'message' => 'File too large'];
        }

        $fileName = uniqid($type . '_') . '_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $targetPath = $this->uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return [
                'success' => true,
                'path' => str_replace('../', '', $targetPath),
                'message' => 'File uploaded successfully'
            ];
        }

        return ['success' => false, 'message' => 'Failed to upload file'];
    }

    public function deleteImage($imagePath) {
        $fullPath = $this->uploadDir . basename($imagePath);
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        return false;
    }
} 