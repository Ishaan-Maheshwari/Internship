<?php
require_once 'vendor/autoload.php';

$collection = (new MongoDB\Client)->users->authcollection;

$document = $collection->findOne(['email'=>$_POST['uemail'], 'password'=>$_POST['upass']]);
if ($document == null){
    echo "Invalid User ID or Password !";
    echo "<br><a href='login.html'>Try again</a>";
    exit;
}
else{
    echo "<h2>Welcome, ".$document['username']."</h2><hr>";
}

?>