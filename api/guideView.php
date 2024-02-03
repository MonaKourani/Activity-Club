<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$guide = new Guide($db);

$result = $guide->view();
$num = $result->rowCount();

if ($num > 0) {
    $guide_arr = array();
    $guide_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $guide_item = array(
            'email' => $email,
            'name' => $name,
            'dateOfBirth' => $dateOfBirth,
            'profession' => $profession
        );

        array_push($guide_arr['data'], $guide_item);
    }

    echo json_encode($guide_arr);
} else {
    echo json_encode(array('message' => 'No guides found.'));
}
?>
