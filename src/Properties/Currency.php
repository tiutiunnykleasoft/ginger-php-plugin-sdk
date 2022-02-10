<?php

namespace GingerPluginSdk\Properties;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Exceptions\OutOfEnumException;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;

final class Currency extends BaseField implements ValidateFieldsInterface
{
    /**
     * @throws \GingerPluginSdk\Exceptions\OutOfEnumException
     */
    public function validate($value)
    {
        //@TODO: IMPLEMENT CACHING CURRENCY LIST AND USE THERE.
        $available_list = [];
        if (in_array($value, $available_list)) {
            throw new OutOfEnumException(key: $this->getPropertyName(), real_value: $value, expected_value: json_encode($available_list));
        }
    }

    public function __construct($value)
    {
        parent::__construct('currency');
        $this->set($value);
    }
}