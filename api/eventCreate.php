<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$event = new Event($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    if (($lastInsertedID = $event->create()) != false) {
        $categories = explode(', ', $event->categories);
        foreach ($categories as $category) {
            $event->addCategoryToLookups($lastInsertedID, $category);
        }
        $guides=explode(', ', $event->guides);
        foreach ($guides as $guide) {
            $event->addGuideToEvent($lastInsertedID, $guide);
        }
        
        echo json_encode(array('message' => 'Event Created'));
    } else {
        echo json_encode(array('message' => 'Unable to create event.'));
    }
} else {
    echo json_encode(array('message' => 'Invalid request method.'));
}
?>
