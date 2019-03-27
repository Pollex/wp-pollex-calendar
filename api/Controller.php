<?php namespace Pollex\Calendar\API;

class Controller extends \WP_REST_Controller {

    protected $namespace;
    protected $base;

    public function __construct($namespace, $base) {
        $this->namespace = $namespace;
        $this->base = $base;
    }

    public function get_full_url() {
        return $this->namespace . '/' . $this->base;
    }

}