<?php namespace Pollex\Calendar\API;

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
                'args' => array( )
            )
        ));
    }

    public function get_events( $request ) {
        return new \WP_Rest_Response( 'Hello world', 200 );
    }

    public function get_events_permission_check( $request ) {
        // TODO: Implement actual permissions
        return true;
    }

}