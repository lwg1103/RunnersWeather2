<?php

namespace App;

abstract class SerializableType implements \JsonSerializable
{
    /** @var int */
    protected $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    abstract public function __toString();

    public function jsonSerialize()
    {
        return [
            'code' => $this->value,
            'name' => (string) $this,
        ];
    }

}
