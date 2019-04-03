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
        $serie_id = 1;
        // Act
        $event = (new EventFactory())
            ->set_id($id)
            ->set_title($title)
            ->set_description($description)
            ->set_start($start)
            ->set_end($end)
            ->set_owner_id($owner_id)
            ->set_serie_id($serie_id)
            ->create();
        // Assert
        $this->assertEquals($id, $event->id);
        $this->assertEquals($title, $event->title);
        $this->assertEquals($description, $event->description);
        $this->assertEquals($start, $event->start);
        $this->assertEquals($end, $event->end);
        $this->assertEquals($owner_id, $event->owner_id);
        $this->assertEquals($serie_id, $event->serie_id);
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
        $serie_id = 1;
        // Act
        $event = (new EventFactory())
            ->set_id($id)
            ->set_title($title)
            ->set_description($description)
            ->set_start($start)
            ->set_end($end)
            ->set_owner_id($owner_id)
            ->set_serie_id($serie_id)
            ->create();
        // Assert
        $this->assertEquals($id, $event->id);
        $this->assertEquals($title, $event->title);
        $this->assertEquals($description, $event->description);
        $this->assertEquals($start, $event->start);
        $this->assertEquals($end, $event->end);
        $this->assertEquals($owner_id, $event->owner_id);
        $this->assertEquals($serie_id, $event->serie_id);
    }

    public function test_creation_from_array() {
        // Arrange
        $id = 0;
        $title = 'Example';
        $description = 'Test description';
        $start = new DateTime('01-03-2019T12:00:00Z');
        $end = new DateTime('01-03-2019T13:00:00Z');
        $owner_id = 1;
        $serie_id = 1;
        // Create the array
        $array = array(
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'start' => $start,
            'end' => $end,
            'owner_id' => $owner_id,
            'serie_id' => $serie_id
        );
        // Act
        $event = (new EventFactory())
            ->from_array($array)
            ->create();
        // Assert
        $this->assertEquals($id, $event->id);
        $this->assertEquals($title, $event->title);
        $this->assertEquals($description, $event->description);
        $this->assertEquals($start, $event->start);
        $this->assertEquals($end, $event->end);
        $this->assertEquals($owner_id, $event->owner_id);
        $this->assertEquals($serie_id, $event->serie_id);
    }

    public function test_creation_from_arrays() {
        // Arrange
        $array1 = array(
            'id' => 1,
            'title' => 'event1',
            'description' => '',
            'start' => '2019-03-01T12:00:00Z',
            'end' => '2019-03-01T12:30:00Z',
            'owner_id' => 0,
            'serie_id' => 1
        );
        $array2 = array(
            'id' => 2,
            'title' => 'event2',
            'description' => '',
            'start' => '2019-03-01T12:00:00Z',
            'end' => '2019-03-01T12:30:00Z',
            'owner_id' => 0,
            'serie_id' => 1
        );
        $array3 = array(
            'id' => 3,
            'title' => 'event3',
            'description' => '',
            'start' => '2019-03-01T12:00:00Z',
            'end' => '2019-03-01T12:30:00Z',
            'owner_id' => 0,
            'serie_id' => 1
        );
        $arrays = [$array1, $array2, $array3];
        // Act
        $events = EventFactory::create_multiple($arrays);
        // Sort returned event titles
        $event_titles = array_map(function($event) { return $event->title; }, $events);
        sort($event_titles);
        // Sort expected titles
        $expected_event_titles = array_map(function($array) { return $array['title']; }, $arrays);
        sort($expected_event_titles);
        // Assert
        $this->assertEquals($expected_event_titles, $event_titles);
    }

}