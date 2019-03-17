<?php

use Pollex\Calendar\Repositories\EventSerieRepository as EventSerieRepository;
use Pollex\Calendar\Models\EventSerie as EventSerie;

class EventSerieRepositoryTest extends \WP_UnitTestCase {
    
    public static function setUpBeforeClass() {
        parent::setUpBeforeClass();
        Pollex_Calendar_Activator::activate();
    }
    
    public function setUp() {
        parent::setUp();
        $event_series_table_name = 'pollex_calendar_event_series';
        $event_series_columns = ['id', 'type'];
        $event_series_format = '%d, %d';
        $this->dummy_event_series = [
            [0, 1],
            [1, 2],
            [2, 3],
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

    public function test_find_by_id() {
        // Arrange
        $id = 1;
        $expected_type = 2;
        $repo = new EventSerieRepository();
        // Act
        $event_serie = $repo->find_by_id($id);
        // Assert
        $this->assertInstanceOf(EventSerie::class, $event_serie);
        $this->assertEquals($id, $event_serie->get_id());
        $this->assertEquals($expected_type, $event_serie->get_type());
    }

    public function test_find_by_id_should_throw_for_not_existing() {
        // Arrange
        $repo = new EventSerieRepository();
        // Expect exception
        $this->setExpectedException(\Exception::class);
        // Act
        $event_serie = $repo->find_by_id(999);
    }

}