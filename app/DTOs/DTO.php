<?php

namespace App\DTOs;

use JsonSerializable;

class DTO implements JsonSerializable
{
    public function __get($name)
    {
        return isset($this->$name)
        ? $this->$name
        : null;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
