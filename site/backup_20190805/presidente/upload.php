
<?php
$target_dir = "../homepage/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//echo "target_file =". $target_file;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
//if(isset($_POST["submit"])) {
//    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//    if($check !== false) {
//        echo "File is an image - " . $check["mime"] . ".";
//        $uploadOk = 1;
//    } else {
//        echo "File is not an image.";
//        $uploadOk = 0;
//    }
//}
// Check if file already exists
//if (file_exists($target_file)) {
//    echo "Sorry, file already exists.";
//    $uploadOk = 0;
//}
// Check file size
//if ($_FILES["fileToUpload"]["size"] > 500000) {
//    echo "Sorry, your file is too large.";
//    $uploadOk = 0;
//}
// Allow certain file formats
if($imageFileType != "php" && $imageFileType != "html" && $imageFileType != "pdf" && $imageFileType != "zip") {
    echo "Errore, solo file .html o .php sono possibili";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Errore, il file non e'stato caricato perche not ok.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Il file ". basename( $_FILES["fileToUpload"]["name"]). " e' stato caricato.";
        if($imageFileType=="zip"){
			$zip = new ZipArchive();
			$res = $zip->open($target_file);
			if ($res === TRUE) {
				// extract it to the path we determined above
				$zip->extractTo($target_dir);
				$zip->close();
				echo " $target_file estratto to $target_dir";
			} else {
				echo "Non ho potuto aprire il file $target_file";
}
			}
    } else {
        echo "Errore, il file non e'stato caricato per un problema di scrittura.";
    }
}
?>
