<?php

use Illuminate\Support\Facades\Auth;


function storeImageFromUrl($url, $path)
{
    $image = file_get_contents($url);
    $image = imagecreatefromstring($image);
    $image = imagejpeg($image, public_path()."{$path}");
    return $image;
}
