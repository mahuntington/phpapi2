<?php
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
    static function update($updatedLocation){
        $query = "UPDATE locations SET street = $1, city = $2, state = $3 WHERE id = $4";
        $query_params = array($updatedLocation->street, $updatedLocation->city, $updatedLocation->state, $updatedLocation->id);
        $result = pg_query_params($query, $query_params);

        return self::all();
    }
    static function all(){
        $locations = array();

        $results = pg_query("SELECT * FROM locations");

        $row_object = pg_fetch_object($results);
        while($row_object){

            $new_location = new Location(
                intval($row_object->id),
                $row_object->street,
                $row_object->city,
                $row_object->state
            );
            $locations[] = $new_location;

            $row_object = pg_fetch_object($results);
        }

        return $locations;
    }
}
?>
