<?php
$dbconn = pg_connect("host=localhost dbname=contacts2");

class Person {
    public $id;
    public $name;
    public $age;
    public function __construct($id, $name, $age) {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
    }
}
class People {
    static function create($person){
        $query = "INSERT INTO people (name, age) VALUES ($1, $2)";
        $query_params = array($person->name, $person->age);
        pg_query_params($query, $query_params);
        return self::all(); //find all people and return them
    }
    static function delete($id){
        $query = "DELETE FROM people WHERE id = $1";
        $query_params = array($id);
        $result = pg_query_params($query, $query_params);

        return self::all();
    }
    static function update($updatedPerson){
        $query = "UPDATE people SET name = $1, age = $2 WHERE id = $3";
        $query_params = array($updatedPerson->name, $updatedPerson->age, $updatedPerson->id);
        $result = pg_query_params($query, $query_params);

        return self::all();
    }
    static function all(){
        //create an empty array
        $people = array();

        //query the database
        $results = pg_query("SELECT * FROM people");

        $row_object = pg_fetch_object($results);
        while($row_object){

            $new_person = new Person(
                intval($row_object->id),
                $row_object->name,
                intval($row_object->age)
            );
            $people[] = $new_person; //push new person object onto $people array

            $row_object = pg_fetch_object($results);
        }

        return $people;
    }
}
?>
