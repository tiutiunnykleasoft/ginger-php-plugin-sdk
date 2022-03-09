<?php

namespace GingerPluginSdk;

use Ginger\ApiClient;
use Ginger\Ginger;
use GingerPluginSdk\Entities\Order;
use GingerPluginSdk\Exceptions\ValidationException;
use GingerPluginSdk\Properties\ClientOptions;
use GingerPluginSdk\Properties\Currency;
use GingerPluginSdk\Response\GingerHTTPResponse;
use GingerPluginSdk\Response\GingerHTTPResponseBody;
use RuntimeException;
use function PHPUnit\Framework\throwException;

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

    /**
     * Methods checks if the payment method is available for the selected currency.
     * The currency list will be retrieved from API or from the cached currency list.
     *
     * @param string $payment_method_name in format without bank label, just `ideal` or `apple-pay`
     * @param \GingerPluginSdk\Properties\Currency $currency
     * @return bool true if method is available / false if creating order with selected payment method and currency is not supporting
     */
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

    /**
     * Remove file which is used for store cached multi-currency.
     * Basically, that action will be needed if users want to update the existing currency array.
     */
    public function removeCachedMultiCurrency()
    {
        unlink(self::MULTI_CURRENCY_CACHE_FILE_PATH);
    }

    /**
     * @throws \GingerPluginSdk\Exceptions\ValidationException
     * @throws \Exception
     */
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
            if (array_key_exists("args", current($exception->getTrace())) && array_key_exists("error", current(current($exception->getTrace())["args"]))) {
                $error = current(current($exception->getTrace())["args"])["error"];
                if (array_key_exists("type", $error) && $error['type'] == 'ValidationError') {
                    throw new ValidationException($error['value'], $error['status']);
                }
            }
            throw new \Exception($exception->getMessage());
        }
        return $response->toArray();
    }
}