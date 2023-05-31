<?php

namespace App\Services\Pictures;

use App\Models\Picture;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

abstract class StorePictureServiceAbstract
{
    const UPLOAD_FOLDER = 'public/images';

    public function store(string $title, string $description, int $userId, ?Picture $picture = null, ?UploadedFile $file = null): Picture
    {
        $picture = $picture ?: new Picture();

        $picture->title = $title;
        $picture->user_id = $userId;
        $picture->description = $description;
        if ($file) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            Storage::putFileAs(self::UPLOAD_FOLDER, $file, $filename);

            $picture->file_path = self::UPLOAD_FOLDER . '/' . $filename;
        }

        $picture->save();

        return $picture;
    }
}
