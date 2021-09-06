<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;

trait HandleImageTrait {

    public function resizeImage($imagePath, $width)
    {
        $image = Image::make($imagePath)->fit($width);
        $image->save();

        return;
    }

    public function deleteImage($imagePath)
    {
        if(!is_file($imagePath))
        {
            return;
        }

        unlink($imagePath);
    }

}