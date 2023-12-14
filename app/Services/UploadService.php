<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Modules\Merchandising\Entities\Style;
use Illuminate\Validation\ValidationException;

class UploadService
{
    public function handleFile($file, $path, $previousFile = null)
    {
        try {
            if (is_string($file)) return $file;
            $fileName = null;
            if ($file) {
                $myRandomString = Str::random(30);
                $fileName = $path . '/' . time() . '-' . $myRandomString . '.' . $file->getClientOriginalExtension();
                $file->move($path, $fileName);
            }

            if ($previousFile) {
                $this->deleteFile($previousFile);
            }
            return $fileName;
        } catch (ValidationException) {
            return null;
        }
    }

    public function deleteFile($oldFile)
    {
        if ($oldFile) {
            $oldPath = public_path($oldFile);
            if (file_exists($oldPath)) {
                File::delete($oldPath);
            }
        }
    }
}
