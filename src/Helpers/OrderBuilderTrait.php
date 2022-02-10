<?php

namespace GingerPluginSdk\Helpers;

use GingerPluginSdk\Entities\Order;

trait OrderBuilderTrait
{
    protected Order $order;

    public function setOrder(Order $order): static
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function sendOrder()
    {
        if (!isset($this->order)) {
            throw  new \Exception("Firstly execute `setOrder` method, to save order");
        }
        try {
            $response = $this->api_client->createOrder($this->order->toArray());
        } catch (\Exception $exception) {

        }
        return $response;
    }
}