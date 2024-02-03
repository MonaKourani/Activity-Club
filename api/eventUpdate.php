<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$event = new Event($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event->eventid = $_POST['eventid'];
    $event->description = $_POST['description'];
    $event->destination = $_POST['destination'];
    $event->dateFrom = $_POST['dateFrom'];
    $event->dateTo = $_POST['dateTo'];
    $event->status = $_POST['status'];
    $event->categories = $_POST['categories'];
    $event->guides = $_POST['guides'];

    $uploadDir = '../images/events/';
    $uploadFile = $uploadDir . basename($_FILES['photo']['name']);

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
        $event->photo = 'images/events/' . basename($_FILES['photo']['name']);
    } else {
        echo json_encode(array('message' => 'Image upload failed.'));
        exit();
    }

    if ($event->edit()) {
        $event->updateCategoriesInLookups($event->eventid, $event->categories);
        $event->updateGuidesInEvent($event->eventid, $event->guides);

        echo json_encode(array('message' => 'Event updated successfully.'));
    } else {
        echo json_encode(array('message' => 'Unable to update event.'));
    }
} else {
    echo json_encode(array('message' => 'Invalid request method.'));
}
?>
