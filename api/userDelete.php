<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$user = new User($db);

if (isset($_GET['email'])) {
    $user->email = $_GET['email'];
    if ($user->delete()) {
        http_response_code(200);
        echo json_encode(array('message' => 'User deleted successfully.'));
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Unable to delete user.'));
    }
} else {
    http_response_code(400);
    echo json_encode(array('message' => 'Missing email parameter.'));
}
?>
