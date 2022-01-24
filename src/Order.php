<?php

namespace GingerPluginSdk;

use GingerPluginSdk\Helpers\orderHelperTrait;

class Order
{
    use orderHelperTrait;

    private $merchant_order_id;

    public function setMerchantOrderId(string $id_string)
    {
        $this->merchant_order_id = $id_string;
    }

    public function getMerchantOrderId(): string
    {
        return $this->merchant_order_id;
    }

    private $amount;

    public function setAmount($amount)
    {
        $this->amount = $this->calculateValueInCents($amount);
    }

    public function getAmount()
    {
        return $this->amount;
    }
}