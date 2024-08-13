<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait HasImages
{

    function getImageFromPath($path)
    {

        if (!Storage::exists($path)) {
            throw new \Exception('File not found.');
        }


        $imageData = Storage::get($path);


        $mimeType = Storage::mimeType($path);


        $base64Image = 'data:' . $mimeType . ';base64,' . base64_encode($imageData);

        return $base64Image;
    }

    function storeImageLocally( $base64Image )
    {
        if (strpos($base64Image, ';base64') !== false) {
            [$type, $base64Image] = explode(';', $base64Image);
            [, $base64Image] = explode(',', $base64Image);
        } else {

            throw new \Exception('Invalid base64 image string.');
        }

        $imageData = base64_decode($base64Image);

        if (strpos($type, 'image/jpeg') !== false) {
            $extension = 'jpg';
        } elseif (strpos($type, 'image/png') !== false) {
            $extension = 'png';
        } elseif (strpos($type, 'image/gif') !== false) {
            $extension = 'gif';
        } elseif (strpos($type, 'image/webp') !== false) {
            $extension = 'webp';
        } else {

            throw new \Exception('Unsupported image type.');
        }


        $fileName = Str::random(10) . '.' . $extension;


        $filePath = 'private/' . $fileName;


        Storage::put($filePath, $imageData);

        return $filePath;
    }
}
