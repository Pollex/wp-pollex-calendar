<?php namespace Pollex\Calendar\API;

use Pollex\Calendar\Repositories\EventRepository as EventRepository;
use Pollex\Calendar\Models\Event as Event;
use Pollex\Calendar\Models\Factories\EventFactory;

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
                'permission_callback' => array( $this, 'get_items_permissions_check' ),
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
            array(
                'methods' => \WP_REST_Server::CREATABLE,
                'callback' => array( $this, 'create_item' ),
                'permissions_callback' => array( $this, 'create_item_permissions_check'),
                'args' => $this->get_endpoint_args_for_item_schema(\WP_REST_Server::CREATABLE)
            ),
            'schema' => array( $this, 'get_item_schema' )
        ));
        // URL: /events/{id}
        register_rest_route($this->namespace, $this->base . '/(?P<id>\d+)', array(
            array (
                'methods' => \WP_REST_Server::READABLE,
                'callback' => array( $this, 'get_item' ),
                'permission_callback' => array( $this, 'get_item_permissions_check' ),
                'args' => array(
                    'id' => array(
                        'validate_callback' => function($param, $request, $key) {
                            return is_numeric($param);
                        }
                    )
                )
            ),
            array(
                'methods' => \WP_REST_Server::EDITABLE,
                'callback' => array( $this, 'update_item' ),
                'permission_callback' => array( $this, 'update_item_permissions_check' ),
                'args' => $this->get_endpoint_args_for_item_schema( \WP_REST_Server::EDITABLE )
            ),
            'schema' => array( $this, 'get_item_schema' )
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

    public function create_item( $request ) {
        $body = $request->get_params();
        // Id should not be set
        if (!empty($body['id'])) {
            return new \WP_Error('rest_event_exists', __('Cannot create existing event.'), array('status' => 400 ) );
        }
        // Save item
        // Create a model from the body
        $event = (new EventFactory())
            ->from_array((array)$body)
            ->set_owner_id(get_current_user_id())
            ->create();
        // Save event to repository
        $repo = new EventRepository();
        $repo->save($event);
        // Prepare for response
        $data = $this->prepare_item_for_response($event, $request);
        // Return created event
        return new \WP_Rest_Response($data, 200);
    }

    public function update_item($request)
    {
        $body = $request->get_params();
        // Id should not be set
        if (empty($body['id'])) {
            return new \WP_Error('rest_event_missing_id', __('Cannot update event without id.'), array('status' => 400));
        }
        // Create the repository
        $repo = new EventRepository();
        // Get item to be updated
        $event = $repo->find_by_id($body['id']);
        // Create updated event
        $event = (new EventFactory())
            ->from_model($event)
            ->from_array($body)
            ->create();
        // Save new item
        $repo->save($event);
        // Prepare event for response
        $data = $this->prepare_item_for_response($event, $request);
        // Return updated event
        return new \WP_Rest_Response($data, 200);
    }

    public function get_items_permissions_check( $request ) {
        // TODO: Implement actual permissions
        return true;
    }

    public function get_item_permissions_check( $request ) {
        // TODO: Implement actual permissions
        return true;
    }

    public function create_item_permissions_check($request)
    {
        // TODO: Implement actual permissions
        return true;
    }

    public function update_item_permissions_check($request)
    {
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
					'type' => 'string',
					'format' => 'date-time',
                ),
                'end' => array(
					'type' => 'string',
					'format' => 'date-time',
                ),
                'serie_id' => array(
                    'type' => 'int'
                )
            ),
            'required' => array(
                'title',
                'description',
                'start',
                'end',
                'serie_id'
            )
        );
        return $schema;
    }

}