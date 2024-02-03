<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$event = new Event($db);

if (isset($_GET['eventid'])) {
    $eventid = $_GET['eventid'];

    $enrolledUsers = $event->getEnrolledUsers($eventid);

    if ($enrolledUsers !== false) {
        http_response_code(200);
        echo json_encode($enrolledUsers);
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Error fetching enrolled users.'));
    }
} else {
    http_response_code(400);
    echo json_encode(array('message' => 'Missing eventid parameter.'));
}
?>
