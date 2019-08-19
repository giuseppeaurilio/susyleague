<?php
$imagedata = base64_decode($_POST['imgdata']);
//echo "imagedata=" . $imagedata;
$filename = "vezio";
//path where you want to upload image
$file = "./" . $filename.'.png';
//echo "file=" . $file;
$imageurl  = './'.$filename.'.png';
file_put_contents($file,$imagedata);
echo $imageurl;
?>
