<?php

namespace GingerPluginSdk;

use Ginger\ApiClient;
use Ginger\Ginger;
use GingerPluginSdk\ClientOptions;
use GingerPluginSdk\OrderBuilder;

class Client
{
    private ApiClient $api_client;

    public function __construct(ClientOptions $options)
    {
        require_once "./vendor/autoload.php";
        $this->api_client = $this->createClient(
            $options->apiKey,
            $options->useBundle,
            $options->endpoint
        );

    }

    private static function getCaCertPath()
    {
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
                    CURLOPT_CAINFO => self::getCaCertPath()
                ] : []
        );
    }
    
    public function getOrderBuilder(): \GingerPluginSdk\OrderBuilder
    {
        return new OrderBuilder();
    }
}