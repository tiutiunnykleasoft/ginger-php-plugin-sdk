<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Client;
use GingerPluginSdk\Entities\PaymentMethodDetails;
use GingerPluginSdk\Entities\Transaction;
use GingerPluginSdk\Exceptions\OutOfEnumException;
use GingerPluginSdk\Properties\ClientOptions;
use GingerPluginSdk\Properties\EmailAddress;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    private Transaction $transaction;
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

        $this->transaction = new Transaction(
            paymentMethod: 'ideal',
            paymentMethodDetails: new PaymentMethodDetails(
                issuer_id: "15"
            )
        );
    }

    public function test_to_array()
    {
        $expected = [
            'payment_method' => 'ideal',
            'payment_method_details' => [
                'issuer_id' => '15'
            ]
        ];
        self::assertSame(
            $expected,
            $this->transaction->toArray()
        );
    }

    public function test_invalid_payment_method_type()
    {
        self::expectException(\TypeError::class);
        $test = new Transaction(
            paymentMethod: 'test', paymentMethodDetails: new EmailAddress('test@mail.nl')
        );
    }

    public function test_payment_method_out_of_enum()
    {
        self::expectException(OutOfEnumException::class);
        $test = new Transaction(
            paymentMethod: 'invalid_type',
            paymentMethodDetails: new PaymentMethodDetails(
                issuer_id: 'test'
            )
        );
    }

    public function test_get_property()
    {
        self::assertSame(
            $this->transaction->getPropertyName(),
            ""
        );
    }

    const MOCK_DATA_FOR_TRANSACTION = [
        "paymentMethod" => 'ideal',
        "paymentMethodDetails" => [
            "issuer_id" => 'UA_AIM'
        ]
    ];


    public function test_additional_property_id()
    {
        $real = $this->client->fromArray(
            Transaction::class,
            array_merge(
                self::MOCK_DATA_FOR_TRANSACTION,
                ["id" => "1234567890"]
            )
        );
        $expected = "1234567890";
        self::assertSame(
            $real->toArray()["id"],
            $expected
        );
    }

    public function test_additional_property_merchant_id()
    {
        $real = $this->client->fromArray(
            Transaction::class,
            array_merge(
                self::MOCK_DATA_FOR_TRANSACTION,
                ["merchant_id" => "1234567890"]
            )
        );
        $expected = "1234567890";
        self::assertSame(
            $real->toArray()["merchant_id"],
            $expected
        );
    }
}
