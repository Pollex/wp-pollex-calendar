<?php

abstract class Pollex_Model_Base
{

    /**
     * Instantiate a model based on the given SQL Row
     * 
     * @since 1.0.0
     */
    protected function __construct($map) {

    }

    /**
     * Save a model to the database.
     * 
     * Saving a model either creates a new one or updates the existing one.
     * This depends on whether the `Id` was set.
     * 
     * @since 1.0.0
     */
    public function save() {

    }

    /**
     * Insert this model as a new row in the database.
     * 
     * @since 1.0.0
     */
    public function create() {

    }

    /**
     * Delete the current model from the database.
     * 
     * Delete this model from the database, based on the `Id` key.
     * 
     * @since 1.0.0
     */
    public function delete() {

    }

    /**
     * Update the current model in the database.
     * 
     * Update the model based on the `Id` key.
     * 
     * @since 1.0.0
     */
    public function update() {

    }

    /**
     * Get a model from the database based on it's `Id` key.
     * 
     * @since 1.0.0
     */
    public static function get($id) {

    }

    /**
     * Get an array of models based on a given where clause.
     * 
     * The where claused is appended after: 
     * `SELECT ... FROM ... WHERE `
     * 
     * @since 1.0.0
     */
    public static function where($where) {
    }

    /**
     * The table name this model is based on.
     * 
     * The table to which this model execute CRUD operations on.
     * 
     * @since 1.0.0
     */
    abstract public static function get_table_name();

    /**
     * Get an array of columns that this model reads.
     * 
     * To avoid unecessarry reading. A sub-class can define what columns have to be read.
     * 
     * @since 1.0.0
     */
    abstract protected static function get_columns();

}
