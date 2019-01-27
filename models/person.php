<?php
include_once __DIR__ . '/location.php';
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
        return self::all();
    }
    static function delete($id){
        $query = "DELETE FROM people WHERE id = $1";
        $query_params = array($id);
        $result = pg_query_params($query, $query_params);

        return self::all();
    }
    static function update($updated_person){
        $query = "UPDATE people SET name = $1, age = $2 WHERE id = $3";
        $query_params = array($updated_person->name, $updated_person->age, $updated_person->id);
        $result = pg_query_params($query, $query_params);

        return self::all();
    }
    static function all(){
        $people = array();

        $results = pg_query("SELECT
            people.*,
            locations.id AS location_id,
            locations.street,
            locations.city,
            locations.state
        FROM people
        LEFT JOIN locations
            ON people.home_id = locations.id;");

        $row_object = pg_fetch_object($results);
        while($row_object){
            $new_person = new Person(
                $row_object->id,
                $row_object->name,
                $row_object->age
            );

            if($row_object->location_id){
                $new_location = new Location(
                    intval($row_object->location_id),
                    $row_object->street,
                    $row_object->city,
                    $row_object->state
                );
                $new_person->home = $new_location;
            }

            $people[] = $new_person;

            $row_object = pg_fetch_object($results);
        }

        return $people;
    }
}
?>
