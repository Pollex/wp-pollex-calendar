<?php

use Pollex\Calendar\Models\Factories\EventFactory as EventFactory;

class EventFactoryTest extends \WP_UnitTestCase {

    public function test_property_setters() {
        // Arrange
        $id = 0;
        $title = 'Example';
        $description = 'Test description';
        $start = new DateTime('01-03-2019T12:00:00Z');
        $end = new DateTime('01-03-2019T13:00:00Z');
        $owner_id = 1;
        // Act
        $event = (new EventFactory())
            ->set_id($id)
            ->set_title($title)
            ->set_description($description)
            ->set_start($start)
            ->set_end($end)
            ->set_owner_id($owner_id)
            ->create();
        // Assert
        $this->assertEquals($id, $event->get_id());
        $this->assertEquals($title, $event->get_title());
        $this->assertEquals($description, $event->get_description());
        $this->assertEquals($start, $event->get_start());
        $this->assertEquals($end, $event->get_end());
        $this->assertEquals($owner_id, $event->get_owner_id());
    }

    public function test_datetime_setter_with_string() {
        // Arrange
        $id = 0;
        $title = 'Example';
        $description = 'Test description';
        $start_str = '01-03-2019T12:00:00Z';
        $start = new DateTime($start_str);
        $end_str = '01-03-2019T13:00:00Z';
        $end = new DateTime($end_str);
        $owner_id = 1;
        // Act
        $event = (new EventFactory())
            ->set_id($id)
            ->set_title($title)
            ->set_description($description)
            ->set_start($start)
            ->set_end($end)
            ->set_owner_id($owner_id)
            ->create();
        // Assert
        $this->assertEquals($id, $event->get_id());
        $this->assertEquals($title, $event->get_title());
        $this->assertEquals($description, $event->get_description());
        $this->assertEquals($start, $event->get_start());
        $this->assertEquals($end, $event->get_end());
        $this->assertEquals($owner_id, $event->get_owner_id());
    }

    public function test_creation_from_array() {
        // Arrange
        $id = 0;
        $title = 'Example';
        $description = 'Test description';
        $start = new DateTime('01-03-2019T12:00:00Z');
        $end = new DateTime('01-03-2019T13:00:00Z');
        $owner_id = 1;
        // Create the array
        $array = array(
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'start' => $start,
            'end' => $end,
            'owner_id' => $owner_id
        );
        // Act
        $event = (new EventFactory())
            ->from_array($array)
            ->create();
        // Assert
        $this->assertEquals($id, $event->get_id());
        $this->assertEquals($title, $event->get_title());
        $this->assertEquals($description, $event->get_description());
        $this->assertEquals($start, $event->get_start());
        $this->assertEquals($end, $event->get_end());
        $this->assertEquals($owner_id, $event->get_owner_id());
    }

}