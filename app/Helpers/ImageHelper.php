<?php

namespace App\Helpers;

class ImageHelper
{
    public static function uploadAndResize($file, $directory, $fileName, $width = null, $height = null)
    {
        $destinationPath = public_path($directory);

if (!file_exists($destinationPath)) {
    mkdir($destinationPath, 0777, true);
}
        $extension = strtolower($file->getClientOriginalExtension());
        $image = null;

        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                $image = imagecreatefromjpeg($file->getRealPath());
                break;
            case 'png':
                $image = imagecreatefrompng($file->getRealPath());
                break;
            case 'gif':
                $image = imagecreatefromgif($file->getRealPath());
                break;
            default:
                throw new \Exception('Unsupported image type');
        }

        if ($width) {
            $oldWidth  = imagesx($image);
            $oldHeight = imagesy($image);

            if ($oldHeight == 0) {
                throw new \Exception('Invalid image height');
            }

            $aspectRatio = $oldWidth / $oldHeight;

            if (!$height) {
                $height = (int) round($width / $aspectRatio);
            }

            $newImage = imagecreatetruecolor((int) $width, (int) $height);
            imagecopyresampled(
                $newImage,
                $image,
                0,
                0,
                0,
                0,
                (int) $width,
                (int) $height,
                $oldWidth,
                $oldHeight
            );

            imagedestroy($image);
            $image = $newImage;
        }

        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                imagejpeg($image, $destinationPath . '/' . $fileName);
                break;
            case 'png':
                imagepng($image, $destinationPath . '/' . $fileName);
                break;
            case 'gif':
                imagegif($image, $destinationPath . '/' . $fileName);
                break;
        }

        imagedestroy($image);
        return $fileName;
    }
}
