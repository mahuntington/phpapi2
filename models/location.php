<?php
include_once __DIR__ . '/person.php';
$dbconn = pg_connect("host=localhost dbname=contacts2");

class Location {
    public $id;
    public $street;
    public $city;
    public $state;
    public function __construct($id, $street, $city, $state) {
        $this->id = $id;
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->inhabitants = [];
    }
}
class Locations {
    static function create($location){
        $query = "INSERT INTO locations (street, city, state) VALUES ($1, $2, $3)";
        $query_params = array($location->street, $location->city, $location->state);
        pg_query_params($query, $query_params);
        return self::all();
    }
    static function delete($id){
        $query = "DELETE FROM locations WHERE id = $1";
        $query_params = array($id);
        $result = pg_query_params($query, $query_params);

        return self::all();
    }
    static function update($updated_location){
        $query = "UPDATE locations SET street = $1, city = $2, state = $3 WHERE id = $4";
        $query_params = array($updated_location->street, $updated_location->city, $updated_location->state, $updated_location->id);
        $result = pg_query_params($query, $query_params);

        return self::all();
    }
    static function all(){
        $locations = array();

        $results = pg_query("SELECT
            locations.*,
            people.id AS person_id,
            people.name,
            people.age
        FROM locations
        LEFT JOIN people
            ON locations.id = people.home_id
        ORDER BY locations.id ASC");

        $row_object = pg_fetch_object($results);
        $last_location_id = null;
        while($row_object){

            if($row_object->id !== $last_location_id){
                $new_location = new Location(
                    $row_object->id,
                    $row_object->street,
                    $row_object->city,
                    $row_object->state
                );
                $locations[] = $new_location;
                $last_location_id = $row_object->id;
            }

            if($row_object->person_id){
                $new_person = new Person(
                    intval($row_object->person_id),
                    $row_object->name,
                    $row_object->age
                );

                $locations_length = count($locations);
                $last_index_of_locations = $locations_length-1;
                $most_recently_added_location = $locations[$last_index_of_locations];
                $most_recently_added_location->inhabitants[] = $new_person;
            }

            $row_object = pg_fetch_object($results);
        }

        return $locations;
    }
}
?>
