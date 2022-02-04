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

    final public function set($value): BaseField
    {
        if ($this instanceof ValidateFieldsInterface) $this->validate($value);
        $this->value = $value;
        return $this;
    }

    final public function get()
    {
        return $this->value;
    }

    final public function getPropertyName(): string
    {
        return $this->property_name;
    }
}