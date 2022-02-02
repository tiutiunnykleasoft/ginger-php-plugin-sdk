<?php

namespace GingerPluginSdk;

use GingerPluginSdk\Entities\Order;

class OrderBuilder
{
    private Order $order;

    public function __construct()
    {

    }

    public function createEmptyOrder()
    {
        return new Order();
    }

    public function build(Order $order)
    {
        $order->checkRequiredFields();

        $this->order = $order;
    }

    public function getOrder(string $id = null): Order
    {
        if ($id) {

        }
        //  $this->order->checkRequiredFields();

        return $this->order;
    }
}