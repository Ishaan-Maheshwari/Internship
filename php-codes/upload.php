<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file '". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). "' has been uploaded.";
	echo "<br><a href='upload.html'>go back</a>";
  }else {
    echo "Sorry, there was an error uploading your file.\n";
	echo "<br><a href='upload.html'>go back</a>";
  }
?>