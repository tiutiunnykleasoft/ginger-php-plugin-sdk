<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Exceptions\OutOfPatternException;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;

final class Email extends BaseField implements ValidateFieldsInterface
{
    /**
     * @throws \GingerPluginSdk\Exceptions\OutOfPatternException
     */
    public function validate($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new OutOfPatternException($this->getPropertyName(), ['test@mail.com', 'another@gmail.com']);
        }
    }

    public function __construct($value)
    {
        parent::__construct('email');
        $this->set($value);
    }
}