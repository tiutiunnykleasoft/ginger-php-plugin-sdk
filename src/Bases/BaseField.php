<?php

namespace GingerPluginSdk\Bases;

use GingerPluginSdk\Interfaces\ValidateFieldsInterface;

abstract class BaseField
{
    private mixed $value;
    private string $property_name;
    protected array $enum;

    public function __construct($property_name)
    {
        $this->property_name = $property_name;
    }

    public function set($value): static
    {
        $this->value = $value;
        if ($this instanceof ValidateFieldsInterface) $this->validate();
        return $this;
    }

    public function get()
    {
        return $this->value;
    }

    public function getPropertyName(): string
    {
        return $this->property_name;
    }
}