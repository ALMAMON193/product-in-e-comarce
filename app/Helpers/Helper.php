<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Helper
{
    public static function uploadFile($folderName, $file, $fileName = null): string
    {
        // Ensure folder exists
        $uploadPath = public_path('uploads/'.$folderName);
        if (! file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Generate file name if not provided
        $fileName = $fileName ?? time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();

        // Get the temporary path from Livewire
        $tempPath = $file->getRealPath();

        // Move the file manually
        if (! rename($tempPath, $uploadPath.'/'.$fileName)) {
            throw new \Exception("Could not move the file to $uploadPath/$fileName");
        }

        return 'uploads/'.$folderName.'/'.$fileName;
    }

    /**
     * Delete a file from public/uploads
     */
    public static function deleteFile(?string $filePath): bool
    {
        if (! $filePath) {
            return false; // nothing to delete
        }

        $fullPath = public_path($filePath);

        // Only unlink if it's a file
        if (file_exists($fullPath) && is_file($fullPath)) {
            return unlink($fullPath);
        }

        return false;
    }

    /**
     * Generate a public URL for the uploaded file
     */
    public static function generateURL(?string $filePath): ?string
    {
        // Check if the path is empty or only whitespace
        if (empty($filePath) || trim($filePath) === '') {
            return null;
        }

        $fullPath = public_path($filePath);

        // Only return URL if file actually exists
        if (file_exists($fullPath)) {
            return asset($filePath);
        }

        return null;
    }
}
