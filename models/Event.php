<?php namespace Pollex\Calendar\Models;

/**
 * Undocumented class
 */
class Event extends Entity{
    private $title;
    private $description;
    private $start;
    private $end;
    private $owner_id;

    public function __construct(int $id, string $title, string $description, \DateTime $start, \DateTime $end, int $owner_id) {
        parent::__construct($id);
        $this->title = $title;
        $this->description = $description;
        $this->start = $start;
        $this->end = $end;
        $this->owner_id = $owner_id;
    }

    public function get_title(){
        return $this->title;
    }
    
    public function get_description(){
        return $this->description;
    }

    public function get_start(){
        return $this->start;
    }

    public function get_end(){
        return $this->end;
    }

    public function get_owner_id(){
        return $this->owner_id;
    }

}