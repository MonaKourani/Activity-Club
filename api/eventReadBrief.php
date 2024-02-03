<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$event = new Event($db);

try {
    $result = $event->readBrief();

    $num = $result->rowCount();

    if ($num > 0) {
        $event_arr = array();
        $event_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $event_item = array(
                'eventid'=>$eventid,
                'description' => $description,
                'status' => $status,
                'photo' => $photo
            );

            array_push($event_arr['data'], $event_item);
        }
        echo json_encode($event_arr);
    } else {
        echo json_encode(array('message' => 'No Events Found'));
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('error' => 'Database Error: ' . $e->getMessage()));
}
?>
