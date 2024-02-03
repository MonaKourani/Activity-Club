<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$message = new Message($db);

$result = $message->view();
$num = $result->rowCount();

if ($num > 0) {
    $message_arr = array();
    $message_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $message_item = array(
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'message' => $message
        );

        array_push($message_arr['data'], $message_item);
    }

    echo json_encode($message_arr);
} else {
    echo json_encode(array('message' => 'No messages found.'));
}
?>
