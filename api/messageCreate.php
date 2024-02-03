<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$message = new Message($db);

if(isset($_POST['name'])){
    $message->name = $_POST['name'];
    $message->email = $_POST['email'];
    $message->message = $_POST['message'];

    if ($message->create()) {
        echo json_encode(array('message' => 'Message created successfully.'));
    } else {
        echo json_encode(array('message' => 'Unable to create message.'));
    }
}
else{
    echo json_encode(array('message' => 'Missing Fields'));
}


?>
