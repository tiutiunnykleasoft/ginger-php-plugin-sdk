<?php

namespace GingerPluginSdk\Helpers;

use GingerPluginSdk\Entities\Order;
use GingerPluginSdk\Response\GingerHTTPResponse;
use GingerPluginSdk\Response\GingerHTTPResponseBody;
use JetBrains\PhpStorm\ArrayShape;

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
    public function debugOrder()
    {
        if (!isset($this->order)) {
            throw  new \Exception("Firstly execute the `setOrder` method, to debug the order");
        }
        print_r($this->order->toArray());
        die(200);
    }

    /**
     * @throws \Exception
     */
    #[ArrayShape(['status' => "bool", 'body' => "array"])] public function sendOrder(): array
    {
        if (!isset($this->order)) {
            throw  new \Exception("Firstly execute the `setOrder` method, to save the order");
        }
        try {
            $success_response = $this->api_client->createOrder($this->order->toArray());
            $response = new GingerHTTPResponse(
                status: true,
                body: new GingerHTTPResponseBody(
                    code: '201',
                    data: $success_response
                )
            );
        } catch (\Exception $exception) {
            $error_body = current(current($exception->getTrace())["args"])["error"];
            $response = new GingerHTTPResponse(
                status: false,
                body: new GingerHTTPResponseBody(
                    code: $error_body['status'],
                    type: $error_body['type'],
                    message: $error_body["value"]
                )
            );
        }
        return $response->toArray();
    }
}