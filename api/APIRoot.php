<?php namespace Pollex\Calendar\API;

class APIRoot extends Controller {

    public function __construct($base = '') {
        $vendor = '/pollex/calendar';
        $version = 1;
        // Set our namespace
        parent::__construct($base . $vendor . '/v' .  $version);
    }

    public function register_endpoints() {
        $events = new EventsController($this->namespace . '/events');
    }

}
