<?php namespace Pollex\Calendar\Models\Factories;

use Pollex\Calendar\Models\Entity as Entity;

abstract class Factory {

    /**
     * For every property that exists, copy the value to the
     * entity being created
     *
     * @param array $array
     * @return Factory
     */
    public function from_array(array $array)
    {
        // Loop key values in array and set accordingly
        foreach( $array as $key => $value) {
            // Check if setter exists
            if (in_array('set_' . $key, get_class_methods($this))) {
                call_user_func(array($this, 'set_' . $key), $value);
            }
        }
        // Allow chaining
        return $this;
    }

    /**
     * Copy properties from an existance model instance
     *
     * @param Entity $model
     * @return void
     */
    public function from_model(Entity $model)
    {
        return $this->from_array( (array) $model );
    }
    
    /**
     * Create multiple entities from arrays
     *
     * @param array $array
     * @return Entity
     */
    public static function create_multiple(array $array)
    {
        // Map each array in $array to a entity model
        $entities = array_map(function($single_array) {
            return (new static())->from_array($single_array)->create();
        }, $array);
        return $entities;
    }

    /**
     * Return the constructed entity
     *
     * @return Entity
     */
    abstract public function create();
}