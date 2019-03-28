<?php

use Pollex\Calendar\Models\Entity as Entity;

class EntityTest extends WP_UnitTestCase {

    /**
     * Test that properties defined in the entities
     * get_properties methods are all read-only.
     */
    public function test_read_only_properties() {
        // Arrange
        $entity = new Entity(5);
        $this->assertEquals(5, $entity->id);
        // Act
        $this->setExpectedException('Error');
        $entity->id = 12;
        // Assert
        $this->assertEquals(5, $entity->id);
    }

}