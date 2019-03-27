<?php namespace Pollex\Calendar\Exceptions;

class EntityNotFoundException extends \Exception {
    public static function create_from_entity_and_id(string $entity, int $id) {
        return new static(sprintf(
            '%s with id %d does not exist',
            $entity,
            $id
        ));
    }
}