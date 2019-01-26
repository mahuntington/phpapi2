<?php
header('Content-Type: application/json');
include_once __DIR__ . '/../models/person.php';

if($_REQUEST['action'] === 'index'){
    echo json_encode(People::all());
} else if ($_REQUEST['action'] === 'post'){
    $request_body = file_get_contents('php://input');
    $body_object = json_decode($request_body);
    $newPerson = new Person(null, $body_object->name, $body_object->age);
    $allPeople = People::create($newPerson); //store the return value of People::create into a var

    //send the return value of People::create (all people in the db) back to the user
    echo json_encode($allPeople);
} else if ($_REQUEST['action'] === 'update'){
    $request_body = file_get_contents('php://input');
    $body_object = json_decode($request_body);
    $updatedPerson = new Person($_REQUEST['id'], $body_object->name, $body_object->age);
    $allPeople = People::update($updatedPerson);

    echo json_encode($allPeople);
} else if ($_REQUEST['action'] === 'delete'){
    $allPeople = People::delete($_REQUEST['id']);
    echo json_encode($allPeople);
}

?>
