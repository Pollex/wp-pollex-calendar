<?php namespace Pollex\Calendar\API;

use Pollex\Calendar\Repositories\EventSerieRepository as EventSerieRepository;
use Pollex\Calendar\Models\Factories\EventSerieFactory;

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
                'permission_callback' => array( $this, 'get_items_permissions_check' ),
                'args' => array()
            ),
            array(
                'methods' => \WP_REST_Server::CREATABLE,
                'callback' => array( $this, 'create_item' ),
                'permission_callback' => array( $this, 'create_item_permissions_check' ),
                'args' => $this->get_endpoint_args_for_item_schema( \WP_REST_Server::CREATABLE )
            ),
            'schema' => array( $this, 'get_item_schema' )
        ));
        register_rest_route($this->namespace, $this->base . '/(?P<id>\d+)', array(
            array(
                'methods' => \WP_REST_Server::EDITABLE,
                'callback' => array( $this, 'update_item' ),
                'permission_callback' => array( $this, 'update_item_permissions_check' ),
                'args' => $this->get_endpoint_args_for_item_schema( \WP_REST_Server::EDITABLE )
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

    public function create_item( $request ) {
        $body = $request->get_params();
        // Id should not be set
        if (!empty($body['id'])) {
            return new WP_Error('rest_event_exists', __('Cannot create existing event.'), array('status' => 400));
        }
        // Save item
        // either create or update, if id exists or not respectively
        return $this->save_item($request, $body);
    }

    public function update_item( $request )
    {
        $body = $request->get_params();
        // Id should not be set
        if (empty($body['id'])) {
            return new WP_Error('rest_event_missing_id', __('Cannot update without id.'), array('status' => 400));
        }
        // Save item
        // either create or update, if id exists or not respectively
        return $this->save_item($request, $body);
    }

    public function save_item( $request, $body = null ) {
        if (empty($body)) {
            $body = $request->get_params();
        }
        // Create model
        $event_serie = (new EventSerieFactory())
            ->from_array($body)
            ->create();
        //
        $repo = new EventSerieRepository();
        $repo->save($event_serie);
        // Prepare for response
        $data = $this->prepare_item_for_response($event_serie, $request);
        // Return created event
        return new \WP_Rest_Response($data, 200 );
    }

    public function get_items_permissions_check( $request ) {
        return true;
    }
    
    public function create_item_permissions_check( $request )
    {
        return true;
    }

    public function update_item_permissions_check($request)
    {
        return true;
    }

    public function prepare_item_for_response($event_serie, $request)
    {
        $response = (array)$event_serie;
        return $response;
    }

    public function get_item_schema()
    {
        $schema = array(
            '$schema'    => 'http://json-schema.org/draft-07/schema#',
            'title'      => 'event_serie',
            'type'       => 'object',
            'properties' => array(
                'type' => array(
                    'type' => 'integer'
                )
            ),
            'required' => array(
                'type'
            )
        );
        return $schema;
    }

}