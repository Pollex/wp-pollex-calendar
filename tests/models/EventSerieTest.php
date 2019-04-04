<?php

use Pollex\Calendar\Models\EventSerie as EventSerie;

class EventSerieTest extends WP_UnitTestCase {

    public function test_construction_success() {
        // Arrange
        $id = 0;
        $type = 1;
        // Act
        $event_serie = new EventSerie($id, $type);
        // Assert
        $this->assertEquals($id, $event_serie->id);
        $this->assertEquals($type, $event_serie->type);
    }

}