<?php
header('Content-Type: application/json');
include_once __DIR__ . '/../models/location.php';

if($_REQUEST['action'] === 'index'){
    echo json_encode(Locations::all());
} else if ($_REQUEST['action'] === 'post'){
    $request_body = file_get_contents('php://input');
    $body_object = json_decode($request_body);
    $newLocation = new Location(null, $body_object->street, $body_object->city, $body_object->state);
    $allLocations = Locations::create($newLocation);

    echo json_encode($allLocations);
} else if ($_REQUEST['action'] === 'update'){
    $request_body = file_get_contents('php://input');
    $body_object = json_decode($request_body);
    $updatedLocation = new Location($_REQUEST['id'], $body_object->street, $body_object->city, $body_object->state);
    $allLocations = Locations::update($updatedLocation);

    echo json_encode($allLocations);
} else if ($_REQUEST['action'] === 'delete'){
    $allLocations = Locations::delete($_REQUEST['id']);
    echo json_encode($allLocations);
}

?>
