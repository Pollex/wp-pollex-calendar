<?php

use Pollex\Calendar\Models\Factories\EventSerieFactory as EventSerieFactory;

class EventSerieFactoryTest extends \WP_UnitTestCase {

    public function test_property_setters() {
        // Arrange
        $id = 0;
        $type = 1;
        // Act
        $event_serie = (new EventSerieFactory())
            ->set_id($id)
            ->set_type($type)
            ->create();
        // Assert
        $this->assertEquals($id, $event_serie->get_id());
        $this->assertEquals($type, $event_serie->get_type());
    }

    public function test_creation_from_array() {
        // Arrange
        $id = 0;
        $type = 1;
        $array = array(
            'id' => $id,
            'type' => $type
        );
        // Act
        $event_serie = (new EventSerieFactory())
            ->from_array($array)
            ->create();
        // Assert
        $this->assertEquals($id, $event_serie->get_id());
        $this->assertEquals($type, $event_serie->get_type());
    }

    public function test_creation_from_arrays() {
        // Arrange
        $array1 = array(
            'id' => 1,
            'type' => 4
        );
        $array2 = array(
            'id' => 2,
            'type' => 5
        );
        $array3 = array(
            'id' => 3,
            'type' => 6
        );
        $arrays = [$array1, $array2, $array3];
        // Act
        $event_series = EventSerieFactory::create_multiple($arrays);
        // Map and sort ids
        $event_serie_ids = array_map(function ($event_serie) { return $event_serie->get_id(); }, $event_series);
        sort($event_serie_ids);
        // Map and sort expected ids
        $expected_event_serie_ids = array_map(function ($array) { return $array['id']; }, $arrays);
        sort($expected_event_serie_ids);
        // Assert
        $this->assertEquals($expected_event_serie_ids, $event_serie_ids);
    }

}