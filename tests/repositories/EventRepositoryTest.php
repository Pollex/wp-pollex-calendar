<?php

use Pollex\Calendar\Repositories\EventRepository as EventRepository;

class EventRepositoryTest extends \WP_UnitTestCase {
    
    public static function setUpBeforeClass() {
        parent::setUpBeforeClass();
        Pollex_Calendar_Activator::activate();
    }
    
    public function setUp() {
        parent::setUp();
        $events_table_name = 'pollex_calendar_events';
        $events_columns = ['serie_id','owner_id','start_datetime','end_datetime','title','description'];
        $events_format = '%d, %d, %s, %s, %s, %s';
        $events = [
            [1, 1, '2019-03-15T12:30:00Z', '2019-03-15T16:00:00Z', 'EventTitle_1', 'lorem ipsum'],
            [1, 1, '2019-03-22T12:30:00Z', '2019-03-22T16:00:00Z', 'EventTitle_2', 'lorem ipsum'],
            [1, 2, '2019-03-29T12:30:00Z', '2019-03-29T16:00:00Z', 'EventTitle_3', 'lorem ipsum'],
            [2, 1, '2019-03-18T09:00:00Z', '2019-03-18T12:00:00Z', 'EventTitle_4', 'lorem ipsum'],
            [2, 1, '2019-03-15T16:30:00Z', '2019-03-15T16:00:00Z', 'EventTitle_5', 'lorem ipsum'],
            [null, 1, '2019-03-12T12:30:00Z', '2019-03-12T16:00:00Z', 'EventTitle_6', 'lorem ipsum'],
            [null, 2, '2019-03-19T12:30:00Z', '2019-03-19T16:00:00Z', 'EventTitle_7', 'lorem ipsum'],
        ];
        $this->insert_dummy_data($events, $events_columns, $events_format, $events_table_name);
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

    /**
     * @dataProvider test_find_all_in_period_provider
     */
    public function test_find_all_in_period($from, $to, $inclusive, $expected_titles) {
        // Arrange
        $repo = new EventRepository();
        $from = new \DateTime($from);
        $to = new \DateTime($to);
        // Act
        $events = $repo->find_all_in_period($from, $to, $inclusive);
        // Get all the titles as array
        $titles = array_map(function ($event) { return $event->get_title(); }, $events);
        sort($titles);
        sort($expected_titles);
        // Assert
        $this->assertEquals($expected_titles, $titles);
    }

    public function test_find_all_in_period_provider() {
        return [
            [
                '2019-03-01T00:00:00Z',
                '2019-03-30T23:59:59Z',
                false,
                ['EventTitle_1', 'EventTitle_2', 'EventTitle_3', 'EventTitle_4', 'EventTitle_5', 'EventTitle_6', 'EventTitle_7']
            ],
            [
                '2019-03-15T00:00:00Z',
                '2019-03-23T23:59:59Z',
                false,
                ['EventTitle_1', 'EventTitle_2', 'EventTitle_4', 'EventTitle_5', 'EventTitle_7']
            ],
            [
                '2019-03-15T15:00:00Z',
                '2019-03-23T23:59:59Z',
                false,
                ['EventTitle_2', 'EventTitle_4', 'EventTitle_5', 'EventTitle_7']
            ],
            [
                '2019-03-01T00:00:00Z',
                '2019-03-30T23:59:59Z',
                true,
                ['EventTitle_1', 'EventTitle_2', 'EventTitle_3', 'EventTitle_4', 'EventTitle_5', 'EventTitle_6', 'EventTitle_7']
            ],
            [
                '2019-03-15T15:00:00Z',
                '2019-03-23T23:59:59Z',
                true,
                ['EventTitle_1', 'EventTitle_2', 'EventTitle_4', 'EventTitle_5', 'EventTitle_7']
            ],
        ];
    }
    
}