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
     * Saves an EventSerie to the repository
     *
     * @param EventSerie $model
     * @return EventSerie 
     */
    public function save(EventSerie &$model)
    {
        global $wpdb;
        // Create a database row from the given model
        $row = $this->create_row_from_model($model);
        // Todo: Decide what we do with an insert fail
        // Update model
        $wpdb->replace(
            $this->TABLE_NAME,
            $row
        );
        // Ensure id is set
        $row['id'] = $wpdb->insert_id;
        // Create a new model, change reference and return
        $model = $this->create_model_from_row($row);
        return $model;
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
        return $results ? $this->create_models_from_rows($results) : array();
    }

    /**
     * Find a specific instance by it's id.
     *
     * @param int $id
     * @return EventSerie
     */
    public function find_by_id(int $id) : ?EventSerie {
        global $wpdb;
        $query = $wpdb->prepare(
            "SELECT * FROM $this->TABLE_NAME WHERE id=%d;",
            $id
        );
        $row = $wpdb->get_row($query, ARRAY_A);
        // Check existance
        if ($row == null) {
            return null;
        }
        // Return
        return $this->create_model_from_row($row);
    }

    /**
     * Prepares a row for the database from a model
     *
     * @param EventSerie $model
     * @return array
     */
    protected function create_row_from_model(EventSerie $model)
    {
        // Create array for database
        $row = array(
            'id' => $model->id,
            'type' => $model->type
        );
        return $row;
    }

    /**
     * Prepares a database row for model creation
     *
     * @param array $row
     * @return array
     */
    protected function create_model_from_row(array $row)
    {
        return (new EventSerieFactory())->from_array($row)->create();
    }

    /**
     * Prepares multiple database rows for model creation
     *
     * @param array $row
     * @return array
     */
    protected function create_models_from_rows(array $rows)
    {
        return EventSerieFactory::create_multiple($rows);
    }
}