<?php namespace Pollex\Calendar\API;

class APIRoot extends Controller {

    public function register_routes() {
        /**
         * Register the EventsController to the /events endpoint.
         */
        $events = new EventsController($this->get_full_url(), 'events');
        $event_series = new EventSeriesController($this->get_full_url(), 'event-series');
        $events->register_routes();
        $event_series->register_routes();

    }

}
