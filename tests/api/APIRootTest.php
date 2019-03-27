<?php

use Pollex\Calendar\API\APIRoot as APIRoot;

class APIRootTest extends \WP_UnitTestCase {

    public function test_full_url_no_base() {
        // Arrange
        $rootapi = new APIRoot('/pollex/calendar/v1');
        // Act
        $full_url = $rootapi->get_full_url();
        // Assert
        $this->AssertEquals('/pollex/calendar/v1', $full_url);
    }

    public function test_full_url_with_base() {
        // Arrange
        $rootapi = new APIRoot('/pollex/calendar/v1', 'events');
        // Act
        $full_url = $rootapi->get_full_url();
        // Assert
        $this->AssertEquals('/pollex/calendar/v1/events', $full_url);
    }

}