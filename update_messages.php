<?php
$db = new mysqli('localhost', 'root', 'password', 'messages');
if($db->connect_error){
die('Connection failed');
}
$username = stripslashes(specialchars($_GET['username']));
$message = stripslashes(specialchars($_GET['message']));
if($username == "" || $message == ""){
die();
}
$result = $db->prepare('INSERT INTO messages VALUE("", ?, ?');
$result->bind_params("ss", $username, $message);
$result->execute();
