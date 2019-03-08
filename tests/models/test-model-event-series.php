<?php
// require_once dirname( __FILE__ ) . '/../../models/class-model-event-series.php';

/**
 * Class Pollex_Model_Base
 */
class Pollex_Model_Event_Series_Test extends WP_UnitTestCase {

    public static function setUpBeforeClass() {
        Pollex_Calendar_Activator::activate();
    }

    public function test_should_insert_new_instance(){
        // Arrange
        $serie = new EventSeries();
        $serie->type = 5;
        $serie->owner_id = 3;
        // Act
        $serie->save();
        // Retrieve by query
        global $wpdb;
        $table_name = EventSeries::get_table_name();
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

    public function test_insert_should_change_model_id() {
        // Arrange
        $serie = new EventSeries();
        $serie->type = 5;
        $serie->owner_id = 3;
        $this->assertEquals(-1, $serie->get_id(), 'ID Should be -1');
        // Act
        $serie->save();
        // Assert ID has changed
        $this->assertNotEquals(-1, $serie->get_id());
        // Retrieve instance based on Id
        global $wpdb;
        $table_name = EventSeries::get_table_name();
        $query = $wpdb->prepare(
            "SELECT * FROM $table_name WHERE id=%d",
            $serie->get_id()
        );
        $row = $wpdb->get_row($query, ARRAY_A);
        // Assert find row in db based on id
        $this->assertNotEquals(null, $row, 'No db row found with model id');
    }
}