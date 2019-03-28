<?php namespace Pollex\Calendar\Models;

class EventSerie extends Entity {

    public $type;

    public function __construct($id, $type) {
        parent::__construct($id);
        $this->type = $type;
    }

}