<?php
$db = new mysqli('localhost', 'root', 'password', 'messages');
if($db->connect_error){
die('DB connection is not successfull');
}
$username = stripslashes(htmlspecialchars($_GET['username']));
$db->prepare('SELECT * FROM messages WHERE username="'.$username.'"');
$db->execute();
$result = $result->get_result();
while($r = $result->fetch_row()){
echo $r[1].'//'.$r[2].'\n';
}
