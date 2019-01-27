<?php
header('Content-Type: application/json');
include_once __DIR__ . '/../models/person.php';

if($_REQUEST['action'] === 'index'){
    echo json_encode(People::all());
} else if ($_REQUEST['action'] === 'post'){
    $request_body = file_get_contents('php://input');
    $body_object = json_decode($request_body);
    $new_person = new Person(null, $body_object->name, $body_object->age);
    $all_people = People::create($new_person);

    echo json_encode($all_people);
} else if ($_REQUEST['action'] === 'update'){
    $request_body = file_get_contents('php://input');
    $body_object = json_decode($request_body);
    $updated_person = new Person($_REQUEST['id'], $body_object->name, $body_object->age);
    $all_people = People::update($updated_person);

    echo json_encode($all_people);
} else if ($_REQUEST['action'] === 'delete'){
    $all_people = People::delete($_REQUEST['id']);
    echo json_encode($all_people);
}

?>
