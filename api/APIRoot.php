<?php namespace Pollex\Calendar\API;

class APIRoot extends Controller {

    public function register_routes() {
        /**
         * Register the EventsController to the /events endpoint.
         */
        $events = new EventsController($this->get_full_url(), 'events');
        $events->register_routes();

    }

}
