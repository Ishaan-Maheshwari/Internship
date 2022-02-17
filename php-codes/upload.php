<?php
$target_dir = "uploads/";

if ($_FILES["fileToUpload"]["error"]) {
	echo "Error in uploading file.\n";
	echo "<br><a href='upload.html'>go back</a>";
	exit;
}
if ($_FILES["fileToUpload"]["size"] > 10485760) {
	echo "ERROR: File is more than 10 Mb";
	echo "<br><a href='upload.html'>go back</a>";
	exit;
}
$img = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if ($img["mime"] != 'image/png'){
	echo "ERROR: File is not of the type 'png'";
	echo "<br><a href='upload.html'>go back</a>";
	exit;
}

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file '". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). "' has been uploaded.";
	echo "<br><a href='upload.html'>go back</a>";
  }else {
    echo "Sorry, there was an error uploading your file.\n";
	echo "<br><a href='upload.html'>go back</a>";
  }
?>
