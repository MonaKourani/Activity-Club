<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$events= new Event($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $enrolledEvents = $events->getEnrolledEvents($_GET['email']);

    echo json_encode($enrolledEvents);
} else {
    echo json_encode(array('message' => 'Invalid request method.'));
}
?>
