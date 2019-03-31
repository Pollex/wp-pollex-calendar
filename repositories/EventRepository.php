<?php namespace Pollex\Calendar\Repositories;

use Pollex\Calendar\Models\Event as Event;
use Pollex\Calendar\Models\Factories\EventFactory as EventFactory;
use Pollex\Calendar\Exceptions\EntityNotFoundException as EntityNotFoundException;

class EventRepository {

    private $TABLE_NAME = 'pollex_calendar_events';
    private $COLUMN_MAPPING = array(
        'start_datetime' => 'start',
        'end_datetime' => 'end'
    );

    public function __construct() {
        global $wpdb;
        $this->TABLE_NAME = $wpdb->prefix . $this->TABLE_NAME;
    }

    /**
     * Find all events in a certain period
     *
     * @return array
     */
    public function find_all_in_period(\DateTime $from, \DateTime $to, bool $inclusive = false) : array {
        global $wpdb;
        
        $from = $from->format(\DateTime::ATOM);
        $to = $to->format(\DateTime::ATOM);
        // If inclusive we want to include running 
        // therefore compare $from to the endDate.
        $start_condition = $inclusive ? 'end_datetime':'start_datetime';
        $query = $wpdb->prepare(
            "SELECT * FROM $this->TABLE_NAME WHERE $start_condition>=%s AND start_datetime<=%s ORDER BY start_datetime ASC;",
            $from,
            $to
        );
        $rows = $wpdb->get_results($query, ARRAY_A);

        return $this->create_models_from_rows($rows);
    }

    /**
     * Find a single event by its id
     *
     * @param integer $id
     * @return Event
     */
    public function find_by_id(int $id) : ?Event {
        global $wpdb;

        // Query for single row by id
        $query = $wpdb->prepare(
            "SELECT * FROM $this->TABLE_NAME WHERE id=%d",
            $id
        );
        $row = $wpdb->get_row($query, ARRAY_A);
        // Check existance
        if ($row == null) {
            // throw EntityNotFoundException::create_from_entity_and_id('Event', $id);
            return null;
        }
        // Return created entity from row
        return $this->create_model_from_row($row);
    }

    /**
     * Prepares a row for the database from a model
     *
     * @param Event $model
     * @return array
     */
    protected function create_row_from_model(Event $model) {
        // Create array for database
        $row = array(
            'id' => $model->id,
            'title' => $model->title,
            'description' => $model->description,
            'start_datetime' => $model->start->format(\DateTime::ATOM),
            'end_datetime' => $model->end->format(\DateTime::ATOM),
            'owner_id' => $model->owner_id
        );
        return $row;
    }

    /**
     * Prepares a database row for model creation
     *
     * @param array $row
     * @return array
     */
    protected function create_model_from_row(array $row) {
        // Map keys
        $this->array_replace_key($row, $this->COLUMN_MAPPING);
        // Create event instance
        return (new EventFactory())->from_array($row)->create();
    }

    /**
     * Prepares multiple database rows for model creation
     *
     * @param array $row
     * @return array
     */
    protected function create_models_from_rows(array $rows)
    {
        foreach($rows as &$row) {
            $this->array_replace_key($row, $this->COLUMN_MAPPING);
        }
        return EventFactory::create_multiple($rows, $this->COLUMN_MAPPING);
    }

    protected function array_replace_key(array &$array, array $mapping) {
        foreach( $array as $key => $value ) {
            // Check if key is mapped
            if ( array_key_exists($key, $mapping) ) {
                $array[$mapping[$key]] = $value;
                unset($array[$key]);
            }
        }
    }

}