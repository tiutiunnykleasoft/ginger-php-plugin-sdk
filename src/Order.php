<?php

namespace GingerPluginSdk;

use GingerPluginSdk\Properties\IdTrait\IdTrait;

class Order
{
    use IdTrait;

    private $merchant_order_id;

    public function setMerchantOrderId(string $id_string)
    {
        $this->merchant_order_id = $id_string;
    }

    public function getMerchantOrderId(): string
    {
        return $this->merchant_order_id;
    }
}