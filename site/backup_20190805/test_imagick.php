<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
$image = new Imagick();
$image->readImageBlob(file_get_contents('figures/MIL.svg'));
$image->setImageFormat("png24");
$image->resizeImage(1024, 768, imagick::FILTER_LANCZOS, 1); 
$image->writeImage('image.png')
?>
