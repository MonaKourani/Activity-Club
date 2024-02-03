<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$event = new Event($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $event->enroll($_POST['email'], $_POST['eventid']);
    echo json_encode($result);
} else {
    echo json_encode(array('message' => 'Invalid request method.'));
}
?>
