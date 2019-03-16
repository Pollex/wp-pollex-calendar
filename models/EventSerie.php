<?php
namespace \Pollex\Calendar\Models;

class EventSerie extends Entity {

    private $type;

    public function __construct($id, $type) {
        super::__construct($id);
        $this->$type = $type;
    }

    public function get_type() {
        return $this->$type;
    }

}