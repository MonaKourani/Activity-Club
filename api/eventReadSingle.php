<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$event = new Event($db);

if (isset($_GET['eventid'])) {
    $event->eventid = $_GET['eventid'];

    try {
        $event->read_single();

        if ($event->eventid) {
            $event_arr = array(
                'eventid' => $event->eventid,
                'description' => $event->description,
                'destination' => $event->destination,
                'dateFrom' => $event->dateFrom,
                'dateTo' => $event->dateTo,
                'status' => $event->status,
                'categories' => $event->categories,
                'guides' => $event->guides,
                'photo' => $event->photo 
            );

            echo json_encode($event_arr);
        } else {
            echo json_encode(array('message' => 'Event not found'));
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array('error' => 'Database Error: ' . $e->getMessage()));
    }
} else {
    echo json_encode(array('error' => 'Missing eventid parameter'));
}
?>
