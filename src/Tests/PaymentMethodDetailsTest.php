<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Entities\PaymentMethodDetails;
use PHPUnit\Framework\TestCase;
use TypeError;

class PaymentMethodDetailsTest extends TestCase
{
    private PaymentMethodDetails $payment_method_details;

    public function setUp(): void
    {
        $this->payment_method_details = new PaymentMethodDetails(
            issuer: "test"
        );
    }

    public function test_to_array()
    {
        $expected = [
            "issuer" => "test"
        ];
        self::assertSame(
            $expected,
            $this->payment_method_details->toArray()
        );
    }

    public function test_payment_method_details_for_ideal()
    {
        $expected = [
            'issuer_id' => '123'
        ];
        self::assertSame(
            $expected,
            (new PaymentMethodDetails())->setPaymentMethodDetailsIdeal('123')->toArray()
        );
    }

    public function test_invalid_constructor_type()
    {
        self::expectException(TypeError::class);
        $test = new PaymentMethodDetails(['key' => 'valid']);
    }

    public function test_get_property()
    {
        self::assertSame(
            $this->payment_method_details->getPropertyName(),
            'payment_method_details'
        );
    }
}
