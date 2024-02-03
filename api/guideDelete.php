<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$guide = new Guide($db);

$guide->email = $_GET['email'];

if ($guide->delete()) {
    http_response_code(200);
    echo json_encode(array('message' => 'Guide deleted successfully.'));
} else {
    http_response_code(500);
    echo json_encode(array('message' => 'Unable to delete guide.'));
}
?>
