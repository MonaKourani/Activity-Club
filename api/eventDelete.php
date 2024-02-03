<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$event = new Event($db);

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $event->eventid = $_GET['eventid'];

    if ($event->delete()) {
        echo json_encode(array('message' => 'Event deleted successfully.'));
    } else {
        echo json_encode(array('message' => 'Unable to delete event.'));
    }
} else {
    echo json_encode(array('message' => 'Invalid request method.'));
}
?>
