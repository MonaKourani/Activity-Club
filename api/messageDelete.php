<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$message = new Message($db);


$message->id = $_GET['id'];

if ($message->delete()) {
    echo json_encode(array('message' => 'Message deleted successfully.'));
} else {
    echo json_encode(array('message' => 'Unable to delete message.'));
}
?>
