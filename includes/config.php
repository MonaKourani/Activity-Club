<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "activity_club"; 
$db = new PDO('mysql:host='.$servername.';dbname='.$database.';charset=utf8',$username,$password);

/* $conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); 
}  */

$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

define('APP_NAME','WildHeart Adventures Club');
?>