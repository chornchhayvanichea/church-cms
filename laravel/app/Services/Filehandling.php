<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileHandling
{
    public function uploadFile($file, $directory)
    {
        if (! $file) {
            return null;
        }

        return $file->store($directory, 'public');
    }

    public function deleteFile($path)
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
