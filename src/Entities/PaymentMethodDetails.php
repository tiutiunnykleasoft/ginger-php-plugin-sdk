<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;

class PaymentMethodDetails implements MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;


    public function __construct(private string $method_name)
    {

    }
}