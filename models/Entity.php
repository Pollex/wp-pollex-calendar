<?php namespace Pollex\Calendar\Models;

class Entity {
    public $id;

    public function __construct(?int $id = null) {
        $this->id = $id;
    }
}