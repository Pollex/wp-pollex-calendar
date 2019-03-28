<?php namespace Pollex\Calendar\Models;

class Entity {
    private $id;

    public function __construct($id) {
        $this->id = $id;
    }

    public function __get($name) {
        if (in_array( $name, static::get_properties() )) {
            return $this->$name;
        }
    }

    public function get_id() {
        return $this->id;
    }

    public static function get_properties() {
        return [ 'id' ];
    }
}