<?php

use PHPUnit\Framework\TestCase;

final class Test_Model extends Pollex_Model_Base {

    public static function get_table_name() {
        return 'test';
    }

    public static function get_columns() {
        return array('id', 'name');
    }

}

final class Pollex_Model_Base_Test extends TestCase {
    public function testShouldConstructFromArray() {
        // Arrange
        $row = array(
            'id' => 0,
            'name' => 'Terry'
        );
        // Act
        $model = new Test_Model($row);
        // Assert instance
        $this->assertInstanceOf(
            Pollex_Model_Base::class,
            $model
        );
        // Assert properties by columns are set
        $this->assertEquals(
            $model->id,
            0
        );
        $this->assertEquals(
            $model->name,
            'Terry'
        );
    }

    public function testShouldReturnArrayOnWhere() {
        // Arrange
        $rows = array(
            array(
                'id' => 0,
                'name' => 'Terry'
            ),
            array(
                'id' => 1,
                'name' => 'Jake'
            ),
            array(
                'id' => 2,
                'name' => 'Amy'
            ),
        );
        global $wpdb;
        $wpdb = $this->getMockBuilder(stdClass::class)
            ->setMockClassName('wpdb')
            ->setMethods(['get_results', 'prepare'])
            ->getMock();
        $wpdb->method('get_results')->willReturn($rows);
        $wpdb->method('prepare')->willReturn('');
        // Act
        $result = Test_Model::where('');
        
        // Assert for each model returned
        for ($i=0; $i < 3; $i++) { 
            // Assign current model
            $model = $result[$i];
            $actual = $rows[$i];
            // Should be an instance of Test_Model
            $this->assertInstanceOf(
                Test_Model::class,
                $model
            );
            // Should have a correct Id
            $this->assertEquals(
                $actual['id'],
                $model->id
            );
            // Should have a name
            $this->assertEquals(
                $actual['name'],
                $model->name
            );
        }
    }
}