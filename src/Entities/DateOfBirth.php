<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Exceptions\OutOfPatternException;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;

final class DateOfBirth extends BaseField implements ValidateFieldsInterface
{
    /**
     * @throws \GingerPluginSdk\Exceptions\OutOfPatternException
     */
    public function validate($value)
    {
        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $value);
        if ($date === false || $date->format('Y-m-d') !== $value) {
            throw new OutOfPatternException($this->getPropertyName(),['2021-09-21', '2022-01-30']);
        }
    }

    public function __construct(string $value)
    {
        parent::__construct('birthdate');
        $this->set($value);
    }
}