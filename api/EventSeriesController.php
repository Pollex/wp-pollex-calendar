<?php namespace Pollex\Calendar\API;

use Pollex\Calendar\Repositories\EventSerieRepository as EventSerieRepository;

class EventSeriesController extends Controller {

    public function register_routes() {
        /**
         * Register the base route for events.
         * This looks something like:
         * /wp-json/pollex/calendar/v1/eventseries
         */
        // URL: /eventseries
        register_rest_route($this->namespace, $this->base, array(
            array(
                'methods' => \WP_REST_Server::READABLE,
                'callback' => array( $this, 'get_items' ),
                'permission_callback' => array( $this, 'get_items_permission_check' ),
                'args' => array(

                )
            )
        ));
    }

    public function get_items( $request ) {
        // Create repo and find all event series
        $repo = new EventSerieRepository();
        $event_series = $repo->find_all();
        // Return found event series
        return new \WP_Rest_Response($event_series, 200);
    }

    public function get_items_permission_check( $request ) {
        return true;
    }

}