<?php

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    echo '<form action="register.php" method="post">
        Name: <input type="text" name="uname" placeholder="Full Name">
        Email Id: <input type="email" name="uemail" placeholder="abc@example.com">
        Password: <input type="password" name="upass" placeholder="Password">
        <input type="submit" value="Sign Up">
    </form>';
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once 'vendor/autoload.php';

    $collection = (new MongoDB\Client)->users->authcollection;

    $insertOneResult = $collection->insertOne([
        'username' => $_POST['uname'],
        'email' => $_POST['uemail'],
        'password' => $_POST['upass'],
    ]);

    if ( $insertOneResult->getInsertedCount() == 1 ){
        echo "You have successfully registered.";
        echo "<br><a href='login.html'>Login here</a>";
    }
}
    //var_dump($insertOneResult->getInsertedId());
?>

