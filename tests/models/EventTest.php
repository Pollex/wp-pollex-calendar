<?php
use Pollex\Calendar\Models\Event as Event;

class EventTest extends \WP_UnitTestCase {

    public function test_construction_success() {
        // Arrange
        $id = 0;
        $title = 'Example';
        $description = 'Test description';
        $start = new DateTime('01-03-2019T12:00:00Z');
        $end = new DateTime('01-03-2019T13:00:00Z');
        $owner_id = 1;
        // Act
        $event = new Event($id, $title, $description, $start, $end, $owner_id);
        // Assert
        $this->assertEquals($id, $event->get_id());
        $this->assertEquals($title, $event->get_title());
        $this->assertEquals($description, $event->get_description());
        $this->assertEquals($start, $event->get_start());
        $this->assertEquals($end, $event->get_end());
        $this->assertEquals($owner_id, $event->get_owner_id());
    }

}