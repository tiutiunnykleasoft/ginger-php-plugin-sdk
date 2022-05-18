<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Client;
use GingerPluginSdk\Properties\ClientOptions;
use PHPUnit\Framework\TestCase;

class GetOrderTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $this->client = new Client(
            new ClientOptions(
                endpoint: "https://api.online.emspay.eu",
                useBundle: true,
                apiKey: getenv('GINGER_API_KEY')
            )
        );
    }

    public function test_get_order()
    {
        $id = "18a11454-af95-421a-a64f-c6f4a7467e0b";
        $expected = $this->client->getApiClient()->getOrder(id: $id);
        $real = $this->client->getOrder(
            id: $id
        )->toArray();
        self::assertSame(
            expected: $expected,
            actual: $real
        );
    }
}