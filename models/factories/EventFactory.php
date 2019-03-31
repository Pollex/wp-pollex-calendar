<?php namespace Pollex\Calendar\Models\Factories;

use Pollex\Calendar\Models\Event as Event;

class EventFactory {

    private $id;
    private $title;
    private $description;
    private $start;
    private $end;
    private $owner_id;

    public function __construct() {
        $id = null;
        $title = '';
        $description = '';
        $start = new \DateTime();
        $end = new \DateTime();
        $owner_id = 0;
    }

    /**
     * Sets the id property
     *
     * @param int $id
     * @return EventFactory
     */
    public function set_id(int $id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Sets the title property
     *
     * @param string $title
     * @return EventFactory
     */
    public function set_title(string $title) {
        $this->title = $title;
        return $this;
    }
    
    /**
     * Sets the description property
     *
     * @param string $description
     * @return EventFactory
     */
    public function set_description(string $description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Sets the start property
     *
     * @param \DateTime|string $start
     * @return EventFactory
     */
    public function set_start($start) {
        if (gettype($start) == 'string') {
            $start = new \DateTime($start);
        }
        $this->start = $start;
        return $this;
    }

    /**
     * Sets the end property
     *
     * @param \DateTime|string $end
     * @return EventFactory
     */
    public function set_end($end) {
        if (gettype($end) == 'string') {
            $end = new \DateTime($end);
        }
        $this->end = $end;
        return $this;
    }

    /**
     * Sets the owner_id property
     *
     * @param int $owner_id
     * @return EventFactory
     */
    public function set_owner_id(int $owner_id) {
        $this->owner_id = $owner_id;
        return $this;
    }

    /**
     * For every property that exists, copy the value to the
     * event being created
     *
     * @param array $array
     * @return EventFactory
     */
    public function from_array(array $array) {
        // Loop key values in array and set accordingly
        foreach($array as $key => $value) {
            // Check if setter exists
            if (in_array( 'set_' . $key, get_class_methods($this))) {
                call_user_func(array( $this, 'set_' . $key), $value);
            }
        }
        // Allow chaining
        return $this;
    }

    /**
     * Return the created event
     *
     * @return Event
     */
    public function create() : Event {
        return new Event(
            $this->id,
            $this->title,
            $this->description,
            $this->start,
            $this->end,
            $this->owner_id
        );
    }

    /*
        Static utilities
    */

    /**
     * Create multiple Events from arrays
     *
     * @param array $array
     * @return Event[*]
     */
    public static function create_multiple(array $array) {
        // Map each array in $array to a event model
        $events = array_map(function($single_array) {
            return (new static())->from_array($single_array)->create();
        }, $array);
        return $events;
    }

}