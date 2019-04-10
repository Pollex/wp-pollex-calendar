<?php

class Pollex_Calendar_Settings
{
    private $plugin_name;

    private $version;

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function register_admin_menu() {
        // Register top-level menu page
        add_menu_page(
            'Pollex&#39; Calendar',
            'Calendar',
            'activate_plugins',
            'pollex-calendar',
            array($this, 'render_admin_page_content'),
            '',
            30
        );
    }

    public function render_admin_page_content() {
        echo '<div id="pollex-calendar-admin-application">Loading...</div>';
    }
}
