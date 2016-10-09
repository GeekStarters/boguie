<?php

// Function to scale an image proportionally to given width!
// The proportions of the image width and height are kept the same.
// Supports jpeg, png and gif images

function createScaledImage($sourcePath, $destinationPath, $width) {
    $imageInfo = getimagesize($sourcePath);
    
    if ($imageInfo === false) {
        return false;
    }
    
    $imageType = $imageInfo[2];
    $image = null;
    
    if($imageType == IMAGETYPE_JPEG) {
        $image = imagecreatefromjpeg($sourcePath);
    } else if ($imageType == IMAGETYPE_GIF) {
        $image = imagecreatefromgif($sourcePath);
    } else if ($imageType == IMAGETYPE_PNG) {
        $image = imagecreatefrompng($sourcePath);
    }
    
    if ($image !== null) {
        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);
        $scalingFactor = $width / $imageWidth;
        $height = $imageHeight * $scalingFactor;
        $newImage = imagecreatetruecolor($width, $height);

        imagecopyresampled($newImage, $image, 0, 0, 0, 0,
                           $width, $height, $imageWidth,
                           $imageHeight);

        if($imageType == IMAGETYPE_JPEG) {
            return imagejpeg($newImage, $destinationPath);
        } else if ($imageType == IMAGETYPE_GIF) {
            return imagegif($newImage, $destinationPath);
        } else if ($imageType == IMAGETYPE_PNG) {
            return imagepng($newImage, $destinationPath, 9);
        } else {
            return false;
        }

    }
    
    return false;
}

?>