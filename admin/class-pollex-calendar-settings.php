<?php

class Pollex_Calendar_Settings
{
    private $plugin_name;

    private $version;

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function setup_options_menu() {
        // Setup menu pages
    }
}
