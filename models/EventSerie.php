<?php namespace Pollex\Calendar\Models;

class EventSerie extends Entity {

    private $type;

    public function __construct($id, $type) {
        parent::__construct($id);
        $this->type = $type;
    }

    public function get_type() {
        return $this->type;
    }

}