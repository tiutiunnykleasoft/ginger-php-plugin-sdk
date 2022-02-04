<?php

namespace GingerPluginSdk\Helpers;

use GingerPluginSdk\Exceptions\LackOfRequiredFieldsException;
use GingerPluginSdk\Exceptions\NotInTypeException;
use GingerPluginSdk\Exceptions\OutOfEnumException;
use GingerPluginSdk\Exceptions\OutOfPatternException;

trait FieldsValidatorTrait
{
    /**
     * @throws \GingerPluginSdk\Exceptions\NotInTypeException
     */
    public function validateType($supported)
    {
        /** @var \GingerPluginSdk\Bases\BaseField $this */
        $value = $this->get();
        if (!in_array(gettype($value), $supported)) {
            throw new NotInTypeException($this->getPropertyName(), $supported);
        }
    }

    /**
     * @throws \GingerPluginSdk\Exceptions\OutOfEnumException
     */
    public function validateEnum($value)
    {
        /** @var \GingerPluginSdk\Bases\BaseField $this */
        if (!in_array($value, $this->enum)) {
            throw new OutOfEnumException($this->getPropertyName(), $value, json_encode($this->enum));
        }
    }

    /**
     * @throws \GingerPluginSdk\Exceptions\OutOfPatternException
     */
    public function validatePattern($value, $pattern, $valid)
    {
        /** @var \GingerPluginSdk\Bases\BaseField $this */
        if (!preg_match($pattern, $value)) {
            throw new OutOfPatternException($this->getPropertyName(), $valid);
        }
    }

    /**
     * @throws \GingerPluginSdk\Exceptions\LackOfRequiredFieldsException
     */
    public function validateRequiredFields(array $except = [])
    {
        /** @var \GingerPluginSdk\Bases\BaseField $this */
        $lack = [];
        foreach ($this->fields as $field => $required) {
            if ($required && !in_array($field, $except) && !isset($this->$field)) {
                $lack[] = $field;
            }
        }
        if ($lack) {
            throw new LackOfRequiredFieldsException(self::class, json_encode($lack));
        }
    }

}