<?php

class Event extends BaseModel
{
    public $serie_id;
    public $owner_id;
    public $start_date;
    public $end_date;
    public $title;
    public $description;

    protected function get_table_name() {
        return 'pollex_calendar_events';
    }

    protected function get_columns() {
        return array(
            'serie_id' => $this->serie_id,
            'owner_id' => $this->owner_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'title' => $this->title,
            'description' => $this->description
        );
    }

    protected static function create_from_row($row) {
        $instance = new static();
        $instance->id = $row['id'];
        $instance->serie_id = $row['serie_id'];
        $instance->owner_id = $row['owner_id'];
        $instance->start_date = $row['start_date'];
        $instance->end_date = $row['end_date'];
        $instance->title = $row['title'];
        $instance->description = $row['description'];
        return $instance;
    }
}
