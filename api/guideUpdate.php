<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$guide = new Guide($db);

if (isset($_POST['email'])) {
    $guide->email = $_POST['email'];
    $guide->name = $_POST['name'];
    $guide->dateOfBirth = $_POST['dateOfBirth'];
    $guide->profession = $_POST['profession'];

    if ($guide->edit()) {
        http_response_code(200);
        echo json_encode(array('message' => 'Guide updated successfully.'));
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Unable to update guide.'));
    }
} else {
    http_response_code(400);
    echo json_encode(array('message' => 'Missing submit parameter.'));
}
?>
