<?php
// require_once dirname( __FILE__ ) . '/../../models/class-model-event-series.php';

/**
 * Class Pollex_Model_Base
 */
class Pollex_Model_Event_Series_Test extends WP_UnitTestCase {

    public static function setUpBeforeClass() {
        Pollex_Calendar_Activator::activate();
    }

    public function test_save_as_new_should_insert_row(){
        // Arrange
        $serie = new EventSeries();
        $serie->type = 5;
        $serie->owner_id = 3;
        // Act
        $serie->save();
        // Retrieve by query
        global $wpdb;
        $table_name = EventSeries::get_full_table_name();
        $query = $wpdb->prepare(
            "SELECT * FROM $table_name WHERE type=%d AND ownerId=%d",
            $serie->type,
            $serie->owner_id
        );
        $row = $wpdb->get_row($query, ARRAY_A);
        // Assert existance
        $this->assertNotEquals(null, $row, 'Instance not found in database');
        $this->assertTrue($row['id'] >= 0);
    }

    public function test_save_as_new_should_change_id() {
        // Arrange
        $serie = new EventSeries();
        $serie->type = 5;
        $serie->owner_id = 3;
        $this->assertEquals(null, $serie->get_id(), 'ID Should be Null');
        // Act
        $serie->save();
        // Assert ID has changed
        $this->assertTrue($serie->get_id() >= 0);
        // Retrieve instance based on Id
        global $wpdb;
        $table_name = EventSeries::get_full_table_name();
        $query = $wpdb->prepare(
            "SELECT * FROM $table_name WHERE id=%d",
            $serie->get_id()
        );
        $row = $wpdb->get_row($query, ARRAY_A);
        // Assert find row in db based on id
        $this->assertNotEquals(null, $row, 'No db row found with model id');
    }

    public function test_save_as_existing_should_update_row() {
        // arrange
        $serie = new EventSeries();
        $serie->type = 3;
        $serie->owner_id = 5;
        $serie->save();
        $this->assertTrue($serie->get_id() >= 0);
        $id = $serie->get_id();
        // act
        $serie->type = 20;
        $serie->save();
        // assert id didn't change (so no new insert happened)
        $this->assertEquals($id, $serie->get_id());
        // get new instance
        $this->assertEquals(
            $serie->type,
            EventSeries::get($id)->type
        );
    }

    public function test_get_should_return_instance_with_same_id() {
        // Insert an instance
        $serie1 = new EventSeries();
        $serie1->type = 1;
        $serie1->owner_id = 15;
        $serie1->save();
        $this->assertTrue($serie1->get_id() >= 0);
        // Act
        $serie2 = EventSeries::get($serie1->get_id());
        // Assert
        $this->assertEquals($serie1->get_id(), $serie2->get_id());
        
    }

    public function test_unbind_should_set_id_to_null() {
        // Arrange
        $serie = new EventSeries();
        $serie->type = 1;
        $serie->owner_id = 5;
        $serie->save();
        $this->assertTrue($serie->get_id() >= 0, 'Model was not saved');
        // Act
        $serie->unbind();
        // Assert
        $this->assertEquals(null, $serie->get_id(), 'ID is not unset');
    }
}