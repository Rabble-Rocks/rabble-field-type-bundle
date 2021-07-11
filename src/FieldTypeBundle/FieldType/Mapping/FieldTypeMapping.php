<?php

namespace Rabble\FieldTypeBundle\FieldType\Mapping;

class FieldTypeMapping
{
    private string $name;

    private string $class;

    public function __construct(string $name, string $class)
    {
        $this->name = $name;
        $this->class = $class;
    }

    public function __toString(): string
    {
        return $this->class;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getClass(): string
    {
        return $this->class;
    }
}
