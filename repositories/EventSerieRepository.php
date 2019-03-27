<?php namespace Pollex\Calendar\Repositories;

use Pollex\Calendar\Models\Factories\EventSerieFactory as EventSerieFactory;
use Pollex\Calendar\Models\EventSerie as EventSerie;

class EventSerieRepository {

    private $TABLE_NAME = 'pollex_calendar_event_series';

    public function __construct() {
        global $wpdb;
        $this->TABLE_NAME = $wpdb->prefix . $this->TABLE_NAME;
    }

    /**
     * Retrieve all event series
     *
     * @return EventSerie[*]
     */
    public function find_all() : array {
        global $wpdb;
        $query = "SELECT * FROM $this->TABLE_NAME;";
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results ? EventSerieFactory::create_multiple($results) : array();
    }

    /**
     * Find a specific instance by it's id.
     *
     * @param integer $id
     * @return EventSerie
     */
    public function find_by_id(int $id) : EventSerie {
        global $wpdb;
        $query = $wpdb->prepare(
            "SELECT * FROM $this->TABLE_NAME WHERE id=%d;",
            $id
        );
        $result = $wpdb->get_row($query, ARRAY_A);
        // Check existance
        if ($result == null) {
            return null;
        }
        // Return
        return (new EventSerieFactory())->from_array($result)->create();
    }
}