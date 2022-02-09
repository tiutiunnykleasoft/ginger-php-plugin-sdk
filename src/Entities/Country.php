<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;
use JetBrains\PhpStorm\Pure;

class Country extends BaseField implements ValidateFieldsInterface
{
    use FieldsValidatorTrait;

    public function __construct($value)
    {
        parent::__construct("country");
        $this->set($value);
    }

    /**
     * @throws \GingerPluginSdk\Exceptions\OutOfPatternException
     */
    public function validate($value)
    {
        $this->validatePattern(
            value: $value,
            pattern: "/^[a-zA-Z]{2}$/",
            valid: ['UA,NL,BE,FR']
        );
    }
}