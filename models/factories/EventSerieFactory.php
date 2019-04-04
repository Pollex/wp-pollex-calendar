<?php namespace Pollex\Calendar\Models\Factories;

use Pollex\Calendar\Models\EventSerie as EventSerie;

class EventSerieFactory extends Factory{

    private $id;
    private $type;

    public function __construct() {
        $this->id = null;
        $this->type = 0;
    }

    /**
     * Sets the id property
     *
     * @param integer $id
     * @return EventSerieFactory
     */
    public function set_id(int $id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Sets the type property
     *
     * @param integer $type
     * @return EventSerieFactory
     */
    public function set_type(int $type) {
        $this->type = $type;
        return $this;
    }

    /**
     * Return the created event serie
     *
     * @return EventSerie
     */
    public function create() : EventSerie {
        return new EventSerie($this->id, $this->type);
    }

}