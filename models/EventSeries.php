<?php

class EventSeries extends BaseModel {

    public $type;
    public $owner_id;

    /**
     * Return an array with all properties with values mapped in an array
     */
    public function get_columns() {
        return array(
            'type' => $this->type,
            'ownerId' => $this->owner_id
        );
    }

    /**
     * Creates an instance from a database row as array
     */
    protected static function create_from_row($row) {
        $instance = new static();
        $instance->id = $row['id'];
        $instance->type = $row['type'];
        $instance->owner_id = $row['ownerId'];
        return $instance;
    }

    /**
     * Return the table name without wpdb prefix
     */
    public static function get_table_name() {
        return 'pollex_calendar_event_series';
    }
}