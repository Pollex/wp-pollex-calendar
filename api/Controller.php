<?php namespace Pollex\Calendar\API;

class Controller extends \WP_REST_Controller {

    protected $namespace;
    protected $base;

    public function __construct($namespace, $base = '') {
        $this->namespace = $namespace;
        $this->base = $base;
    }

    public function get_full_url() {
        $full_url = $this->namespace;
        if (!empty($this->base)) {
            $full_url .= '/' . $this->base;
        }
        return $full_url;
    }

}