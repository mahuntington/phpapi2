<?php
header('Content-Type: application/json');
include_once __DIR__ . '/../models/location.php';

if($_REQUEST['action'] === 'index'){
    echo json_encode(Locations::all());
} else if ($_REQUEST['action'] === 'post'){
    $request_body = file_get_contents('php://input');
    $body_object = json_decode($request_body);
    $new_location = new Location(null, $body_object->street, $body_object->city, $body_object->state);
    $all_locations = Locations::create($new_location);

    echo json_encode($all_locations);
} else if ($_REQUEST['action'] === 'update'){
    $request_body = file_get_contents('php://input');
    $body_object = json_decode($request_body);
    $updated_location = new Location($_REQUEST['id'], $body_object->street, $body_object->city, $body_object->state);
    $all_locations = Locations::update($updated_location);

    echo json_encode($all_locations);
} else if ($_REQUEST['action'] === 'delete'){
    $all_locations = Locations::delete($_REQUEST['id']);
    echo json_encode($all_locations);
}

?>
