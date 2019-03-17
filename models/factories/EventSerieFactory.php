<?php namespace Pollex\Calendar\Models\Factories;

use Pollex\Calendar\Models\EventSerie as EventSerie;

class EventSerieFactory {

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
     * For every property that exists, copy the value to the
     * event being created
     *
     * @param array $array
     * @return EventSerieFactory
     */
    public function from_array(array $array, $property_mapping = null) {
        foreach(EventSerie::get_properties() as $property) {
            // If the property is mapped, use that
            $mapped_property = $property_mapping[$property] ?? $property;
            // Check if the given array has this property from iteration
            $array_has_key = array_key_exists($mapped_property, $array);
            // Check if factory contains a setter method for this property
            $setter_method = "set_$property";
            $key_has_setter = in_array($setter_method, \get_class_methods(static::class));
            // If array has key and factory has a setter for it, apply it
            if ($array_has_key && $key_has_setter) {
                $this->$setter_method($array[$mapped_property]);
            }
        }
        // Allow chaining
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

    /*
        Static utilities
    */

    /**
     * Create multiple EventSeries from arrays
     *
     * @param array $array
     * @return EventSerie[*]
     */
    public static function create_multiple(array $array, array $property_mapping = null) {
        // var_dump($array);
        $events = [];
        foreach ($array as $_ => $mapping) {
            $event = (new static())->from_array($mapping, $property_mapping)->create();
            array_push($events, $event);
        }
        return $events;
    }

}