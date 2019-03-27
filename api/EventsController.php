<?php namespace Pollex\Calendar\API;

use Pollex\Calendar\Repositories\EventRepository as EventRepository;

class EventsController extends Controller{

    public function register_routes() {
        /**
         * Register the base route for events.
         * This looks something like:
         * /wp-json/pollex/calendar/v1/events
         */
        register_rest_route($this->namespace, $this->base, array(
            array(
                'methods' => \WP_REST_Server::READABLE,
                'callback' => array( $this, 'get_events' ),
                'permission_callback' => array( $this, 'get_events_permission_check' ),
                'args' => array(
                    'start' => array(
                        'required' => true,
                        'validate_callback' => 'rest_parse_date'
                    ),
                    'end' => array(
                        'required' => true,
                        'validate_callback' => 'rest_parse_date'
                    )
                )
            )
        ));
    }

    public function get_events( $request ) {
        // Parse start and end datetimes
        $start = new \DateTime($request->get_param('start'));
        $end = new \DateTime($request->get_param('end'));
        // Create a repository and request the data
        $repo = new EventRepository();
        $data = $repo->find_all_in_period($start, $end);
        // Respond with data
        return new \WP_Rest_Response( $data, 200 );
    }

    public function get_events_permission_check( $request ) {
        // TODO: Implement actual permissions
        return true;
    }

}