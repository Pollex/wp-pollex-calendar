<?php namespace Pollex\Calendar\Repositories;

use Pollex\Calendar\Models\Factories\EventFactory as EventFactory;

class EventRepository {

    private $TABLE_NAME = 'pollex_calendar_events';
    private $COLUMN_MAPPING = array(
        'start' => 'start_datetime',
        'end' => 'end_datetime'
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
        $results = $wpdb->get_results($query, ARRAY_A);

        return EventFactory::create_multiple($results, $this->COLUMN_MAPPING);
    }

    /**
     * Find a single event by its id
     *
     * @param integer $id
     * @return Event
     */
    public function find_by_id(int $id) {
        global $wpdb;

        // Query for single row by id
        $query = $wpdb->prepare(
            "SELECT * FROM $this->TABLE_NAME WHERE id=%d",
            $id
        );
        $result = $wpdb->get_row($query, ARRAY_A);

        // Return created entity from row
        return (new EventFactory())->from_array($result)->create();
    }

}