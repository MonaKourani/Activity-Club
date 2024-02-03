<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$guide = new Guide($db);

if (isset($_GET['email'])) {
    $guide->email = $_GET['email'];

    $result = $guide->readSingle();

    if ($result) {
        http_response_code(200);
        echo json_encode($result);
    } else {
        http_response_code(404);
        echo json_encode(array('message' => 'Guide not found.'));
    }
} else {
    http_response_code(400);
    echo json_encode(array('message' => 'Missing email parameter.'));
}
?>