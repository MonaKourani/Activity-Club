<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$event = new Event($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['email']) && isset($_POST['eventid'])) {
        $email = $_POST['email'];
        $eventid = $_POST['eventid'];
        $result = $event->unenroll($email, $eventid);

        if (!empty($result['message'])) {
            http_response_code(200);
            echo json_encode(array('message' => $result['message']));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Internal Server Error'));
        }
    } else {
        http_response_code(400);
        echo json_encode(array('message' => 'Missing email or eventid'));
    }
} else {
    http_response_code(405); 
    echo json_encode(array('message' => 'Invalid request method'));
}
?>
