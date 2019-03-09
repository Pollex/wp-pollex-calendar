<?php

class EventAttribute extends BaseModel {

    public $event_id;
    public $key;
    public $value;

    /**
     * Create an instance from a row.
     * 
     * The row is an associative array
     */
    protected static function create_from_row($row) {
        $instance = new static();
        $instance->id = $row['id'];
        $instance->event_id = $row['event_id'];
        $instance->key = $row['attributeKey'];
        $instance->value = $row['attributeValue'];
        return $instance;
    }

    /**
     * Return an array with all properties with values mapped in an array
     */
    protected function get_columns() {
        return array(
            'eventId' => $this->event_id,
            'attributeKey' => $this->key,
            'attributeValue' => $this->value
        );
    }

    /**
     * Return the table name without wpdb prefix
     */
    protected static function get_table_name() {
        return 'pollex_calendar_event_attributes';
    }
}