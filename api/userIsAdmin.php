<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user->email = $_GET['email'];

    if ($user->isAdmin()) {
        echo json_encode(array('isAdmin' => true));
    } else {
        echo json_encode(array('isAdmin' => false));
    }
} else {
    echo json_encode(array('message' => 'Invalid request method.'));
}
?>
