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

    public function test_creation_from_arrays() {
        // Arrange
        $array1 = array(
            'id' => 1,
            'title' => 'event1',
            'description' => '',
            'start' => '2019-03-01T12:00:00Z',
            'end' => '2019-03-01T12:30:00Z',
            'owner_id' => 0
        );
        $array2 = array(
            'id' => 2,
            'title' => 'event2',
            'description' => '',
            'start' => '2019-03-01T12:00:00Z',
            'end' => '2019-03-01T12:30:00Z',
            'owner_id' => 0
        );
        $array3 = array(
            'id' => 3,
            'title' => 'event3',
            'description' => '',
            'start' => '2019-03-01T12:00:00Z',
            'end' => '2019-03-01T12:30:00Z',
            'owner_id' => 0
        );
        $arrays = [$array1, $array2, $array3];
        // Act
        $events = EventFactory::create_multiple($arrays);
        // Sort returned event titles
        $event_titles = array_map(function($event) { return $event->get_title(); }, $events);
        sort($event_titles);
        // Sort expected titles
        $expected_event_titles = array_map(function($array) { return $array['title']; }, $arrays);
        sort($expected_event_titles);
        // Assert
        $this->assertEquals($expected_event_titles, $event_titles);
    }

}