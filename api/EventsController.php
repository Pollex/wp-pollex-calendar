<?php namespace Pollex\Calendar\API;

use Pollex\Calendar\Repositories\EventRepository as EventRepository;
use Pollex\Calendar\Models\Event as Event;

class EventsController extends Controller{

    public function register_routes() {
        /**
         * Register the base route for events.
         * This looks something like:
         * /wp-json/pollex/calendar/v1/events
         */
        // URL: /events
        register_rest_route($this->namespace, $this->base, array(
            array(
                'methods' => \WP_REST_Server::READABLE,
                'callback' => array( $this, 'get_items' ),
                'permission_callback' => array( $this, 'get_items_permission_check' ),
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
            ),
            'schema' => 'get_public_item_schema'
        ));
        // URL: /events/{id}
        register_rest_route($this->namespace, $this->base . '/(?P<id>\d+)', array(
            array (
                'methods' => \WP_REST_Server::READABLE,
                'callback' => array( $this, 'get_item' ),
                'permission_callback' => array( $this, 'get_item_permission_check' ),
                'args' => array(
                    'id' => array(
                        'validate_callback' => function($param, $request, $key) {
                            return is_numeric($param);
                        }
                    )
                )
            ),
            'schema' => 'get_public_item_schema'
        ));
    }

    public function get_items( $request ) {
        // Parse start and end datetimes
        $start = new \DateTime($request->get_param('start'));
        $end = new \DateTime($request->get_param('end'));
        // Create a repository and request the data
        $repo = new EventRepository();
        $events = $repo->find_all_in_period($start, $end);
        // Prepare for response
        $data = [];
        foreach ($events as $event) {
            $prepared_event = $this->prepare_item_for_response($event, $request);
            $data[] = $this->prepare_response_for_collection($prepared_event);
        }
        // Respond with data
        return new \WP_Rest_Response( $data, 200 );
    }

    public function get_item( $request ) {
        $error = new \WP_Error( 'rest_event_invalid_id', __( 'Invalid event ID.' ), array( 'status' => 404 ) );
        // Get id from url
        $id = $request->get_param( 'id' );
        // Create repository and get event
        $repo = new EventRepository();
        $event = $repo->find_by_id($id);
        // Check if we have a result
        if (empty( $event )) {
            return $error;
        }
        // Prepare for response
        $data = $this->prepare_item_for_response($event, $request);
        // Respond
        return new \WP_Rest_Response( $data, 200 );
    }

    public function get_items_permission_check( $request ) {
        // TODO: Implement actual permissions
        return true;
    }

    public function get_item_permission_check( $request ) {
        // TODO: Implement actual permissions
        return true;
    }

    public function prepare_item_for_response( $event, $request ) {
        $response = (array)$event;
        // Format datetime objects
        $response['start'] = $event->start->format(\DateTime::ATOM);
        $response['end'] = $event->end->format(\DateTime::ATOM);
        return $response;
    }

    public function get_item_schema() {
		$schema = array(
			'$schema'    => 'http://json-schema.org/draft-07/schema#',
			'title'      => 'event',
			'type'       => 'object',
			'properties' => array(
                'title' => array(
                    'type' => 'string'
                ),
                'description' => array(
                    'type' => 'string'
                ),
                'start' => array(
					'type'        => 'string',
					'format'      => 'date-time',
                ),
                'end' => array(
					'type'        => 'string',
					'format'      => 'date-time',
                )
            ),
            'required' => array(
                'title',
                'description',
                'start',
                'end'
            )
        );
        return $schema;
    }

}