<?php namespace Pollex\Calendar\API;

class Pollex_Calendar_API {
    
    private $vendor = '/pollex/calendar';
    private $version = 1;
    private $namespace;


    public function __construct($base = '') {
        $this->namespace = $base . $this->vendor . '/v' .  $this->version;
    }

    public function register_endpoints() {
        
    }

}
