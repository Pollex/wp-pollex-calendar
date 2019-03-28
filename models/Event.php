<?php namespace Pollex\Calendar\Models;

/**
 * Undocumented class
 */
class Event extends Entity{
    public $title;
    public $description;
    public $start;
    public $end;
    public $owner_id;

    public function __construct(int $id, string $title, string $description, \DateTime $start, \DateTime $end, int $owner_id) {
        parent::__construct($id);
        $this->title = $title;
        $this->description = $description;
        $this->start = $start;
        $this->end = $end;
        $this->owner_id = $owner_id;
    }

}