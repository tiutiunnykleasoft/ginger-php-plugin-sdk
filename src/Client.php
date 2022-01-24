<?php

namespace GingerPluginSdk;

use Ginger\ApiClient;
use Ginger\Ginger;
use GingerPluginSdk\Properties\ClientOptions;

class Client
{
    private $api_client;

    public function __construct(ClientOptions $options)
    {
        require_once "./vendor/autoload.php";
        $this->api_client = $this->createClient(
            $options->apiKey,
            $options->useBudle,
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
                    CURLOPT_CAINFO => self::getCaCertPath()
                ] : [],
        );
    }
}