<?php

namespace GingerPluginSdk;

use Ginger\ApiClient;
use Ginger\Ginger;
use GingerPluginSdk\Entities\Order;
use GingerPluginSdk\Properties\ClientOptions;
use GingerPluginSdk\Properties\Currency;
use GingerPluginSdk\Response\GingerHTTPResponse;
use GingerPluginSdk\Response\GingerHTTPResponseBody;
use RuntimeException;

class Client
{

    const MULTI_CURRENCY_CACHE_FILE_PATH = __DIR__ . "/Assets/payment_method_currencies.json";
    const CA_CERT_FILE_PATH = __DIR__ . '/Assets/cacert.pem';
    protected ApiClient $api_client;

    public function __construct(ClientOptions $options)
    {
        $this->api_client = $this->createClient(
            $options->apiKey,
            $options->useBundle,
            $options->endpoint
        );

    }

    public function getApiClient(): ApiClient
    {
        return $this->api_client;
    }

    public function createClient($apiKey, $useBundle, $endpoint): ApiClient
    {
        return Ginger::createClient(
            $endpoint,
            $apiKey,
            $useBundle ?
                [
                    CURLOPT_CAINFO => self::CA_CERT_FILE_PATH
                ] : []
        );
    }

    public function checkAvailabilityForPaymentMethodUsingCurrency(string $payment_method_name, Currency $currency): bool
    {
        $file_content = "";

        if (file_exists(self::MULTI_CURRENCY_CACHE_FILE_PATH)) {
            $file_content = json_decode(current(file(self::MULTI_CURRENCY_CACHE_FILE_PATH)));
        }

        if (empty($file_content) || $file_content->expiration_time <= time()) {
            $std = new \stdClass();
            $std->expiration_time = time() + (60 * 6);
            $std->currency_list = $this->api_client->getCurrencyList();
            file_put_contents(filename: self::MULTI_CURRENCY_CACHE_FILE_PATH, data: json_encode($std));
        }

        $currency_list = json_decode(current(file(self::MULTI_CURRENCY_CACHE_FILE_PATH)))->currency_list;

        return in_array($currency->get(), $currency_list->payment_methods->$payment_method_name->currencies);
    }

    public function sendOrder(Order $order): array
    {
        try {
            $success_response = $this->api_client->createOrder($order->toArray());
            $response = new GingerHTTPResponse(
                status: true,
                body: new GingerHTTPResponseBody(
                    code: '201',
                    data: $success_response
                )
            );
        } catch (RuntimeException $exception) {
            print_r($exception->getMessage());exit;
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