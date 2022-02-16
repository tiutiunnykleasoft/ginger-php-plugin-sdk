<?php

namespace GingerPluginSdk\Helpers;

use Ginger\HttpClient\HttpException;
use GingerPluginSdk\Entities\Order;
use GingerPluginSdk\Response\GingerHTTPResponse;
use GingerPluginSdk\Response\GingerHTTPResponseBody;
use JetBrains\PhpStorm\ArrayShape;
use RuntimeException;

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
        } catch (RuntimeException $exception) {
            $args = $exception->getTrace()[0]["args"][0];
            $error_body = $args["error"];
            $additional_error_data = [
                'property_description' => $error_body['property_description'] ?? null,
                'property_path' => $error_body['property_path'] ?? null
            ];
            $response = new GingerHTTPResponse(
                status: false,
                body: new GingerHTTPResponseBody(
                    code: $error_body['status'],
                    data: $error_body["type"] == 'ValidationError' ? $additional_error_data : null,
                    type: $error_body['type'] ?? null,
                    message: $error_body["value"]
                )
            );
        }
        return $response->toArray();
    }
}