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
    public function testCanConstructFromArray() {
        // Arrange
        $row = array(
            'id' => 0,
            'name' => 'Terry'
        );
        // Act
        $model = new Test_Model($row);
        // Assert
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
}