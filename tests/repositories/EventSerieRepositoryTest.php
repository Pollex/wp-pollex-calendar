<?php

use Pollex\Calendar\Repositories\EventSerieRepository as EventSerieRepository;
use Pollex\Calendar\Models\EventSerie as EventSerie;
use Pollex\Calendar\Models\Factories\EventSerieFactory;

class EventSerieRepositoryTest extends \WP_UnitTestCase {
    
    public static function setUpBeforeClass() {
        parent::setUpBeforeClass();
        Pollex_Calendar_Activator::activate();
    }
    
    public function setUp() {
        parent::setUp();
        $event_series_table_name = 'pollex_calendar_event_series';
        $event_series_columns = ['type'];
        $event_series_format = '%d';
        $this->dummy_event_series = [
            [1],
            [2],
            [3],
        ];
        $this->insert_dummy_data($this->dummy_event_series, $event_series_columns, $event_series_format, $event_series_table_name);
    }

    public function insert_dummy_data($data, $columns, $format, $table_name) {
        global $wpdb;
        $table_name = $wpdb->prefix . $table_name;
        $columns = implode(',', $columns);
        $format = "($format)";
        $format = str_replace('%s', '\'%s\'', $format);
        // Create a nice value query
        $query_values = implode(',',
            array_map(function ($item) use ($format) {
                return sprintf($format, ...$item);
            }, $data)
        );
        // Prepare and execute this amazing, unescaped and totally safe query
        $query = "INSERT INTO $table_name($columns) VALUES $query_values;";
        $wpdb->get_results($query);
    }

    public function test_find_all() {
        // Arrange
        $repo = new EventSerieRepository();
        // Act
        $event_series = $repo->find_all();
        // Assert
        foreach ($event_series as $event_serie) {
            $this->assertInstanceOf(EventSerie::class, $event_serie);
        }
        $this->assertCount(count($this->dummy_event_series), $event_series);
    }

    /**
     * @dependsOn test_find_all
     */
    public function test_find_by_id() {
        // Arrange
        $repo = new EventSerieRepository();
        $expected_serie = $repo->find_all()[0];
        // Act
        $event_serie = $repo->find_by_id($expected_serie->id);
        // Assert
        $this->assertInstanceOf(EventSerie::class, $event_serie);
        $this->assertEquals($expected_serie->id, $event_serie->id);
        $this->assertEquals($expected_serie->type, $event_serie->type);
    }

    public function test_find_by_id_null_for_not_existing() {
        // Arrange
        $repo = new EventSerieRepository();
        // Act
        $event_serie = $repo->find_by_id(999);
        // Assert
        $this->assertEquals(null,$event_serie);
    }

    public function test_save_as_insert()
    {
        // Arrange
        $repo = new EventSerieRepository();
        $event_serie = (new EventSerieFactory())
            ->set_type(1)
            ->create();
        // Act
        $repo->save($event_serie);
        // Assert
        $this->assertFalse(empty($event_serie->id), 'EventSerie id should be set after insert');
    }

    public function test_save_as_replace()
    {
        // Arrange
        $repo = new EventSerieRepository();
        $event_serie = $repo->find_all()[0];
        $old_type = $event_serie->type;
        $new_type = 100;
        // Act
        $event_serie->type = $new_type;
        $repo->save($event_serie);
        // Assert
        // Re-Query same event to make sure it comes from the database
        $event_serie_2 = $repo->find_all()[0];
        $this->assertEquals($new_type, $event_serie_2->type);
        
    }

}