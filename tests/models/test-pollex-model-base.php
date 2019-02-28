<?php
/**
 * Class SampleTest
 *
 * @package Pollex_Calendar
 */



class Pollex_Model_Base_Constructor_Test extends WP_UnitTestCase {

}

class Pollex_Model_Base_Save_Test extends WP_UnitTestCase {
    
}

class Pollex_Model_Base_Create_Test extends WP_UnitTestCase {

}

class Pollex_Model_Base_Delete_Test extends WP_UnitTestCase {
    
}

class Pollex_Model_Base_Update_Test extends WP_UnitTestCase {
    
}

class Pollex_Model_Base_Query_Test extends WP_UnitTestCase {
    
}

final class Test_Model extends Pollex_Model_Base {

    public static function get_table_name() {
        return 'test';
    }

    public static function get_columns() {
        return array('id', 'name');
    }

}