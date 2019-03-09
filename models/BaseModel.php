<?php

abstract class BaseModel
{
    protected $id;

    /**
     * Save this instance to the database.
     * 
     * Saves the instance if it has an ID and thus already exists.
     * Otherwise insert it and set id.
     */
    public function save() {
        if ($this->id > 0) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    /**
     * Unbind a model from the database.
     * 
     * Unbinding a model from a database means that there is no
     * relation anymore to a database row. In simple words, the 
     * model's id is no longer set and the instance will be 
     * treated as if it is new.
     */
    public function unbind() {
        $this->id = null;
    }

    /**
     * Update this instance based on id.
     */
    protected function update() {
        global $wpdb;
        $wpdb->update(
            static::get_full_table_name(),
            static::get_columns(),
            array(
                'id' => $this->id
            )
        );
    }

    /**
     * Get this instance's id.
     * 
     * Id is -1 if not bound to a database row.
     */
    public function get_id() {
        return $this->id;
    }

    /**
     * Insert this instance into the database.
     */
    protected function insert() {
		global $wpdb;
		$wpdb->insert(
			static::get_full_table_name(),
			static::get_columns()
        );
        // TODO: Check if insert was succesful
        $this->id = $wpdb->insert_id;
    }

    /**
     * Retrieves a single instance from the database
     */
    public static function get($id) {
        global $wpdb;
        $table_name = static::get_full_table_name();
        $query = $wpdb->prepare(
            "SELECT * FROM $table_name WHERE id=%d",
            $id
        );
        $row = $wpdb->get_row($query, ARRAY_A);
        return static::create_from_row($row);
    }

    /**
     * Returns the full table name with prefix
     */
    public static function get_full_table_name() {
        global $wpdb;
        return $wpdb->prefix . static::get_table_name();
    }

    /**
     * Create an instance from a row.
     * 
     * The row is an associative array
     */
    protected static abstract function create_from_row($row);

    /**
     * Return an array with all properties with values mapped in an array
     */
    protected abstract function get_columns();

    /**
     * Return the table name without wpdb prefix
     */
    protected static abstract function get_table_name();
}
