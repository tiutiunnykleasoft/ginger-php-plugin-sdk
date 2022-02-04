<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;

final class Transaction implements MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;
    use SingleFieldTrait;

    private BaseField $payment_method;

    public function __construct(string $payment_method)
    {
        $this->payment_method = $this->createEnumeratedField(
            property_name: 'payment_method',
            value: $payment_method,
            enum: [
                "afterpay",
                "amex",
                "apple-pay",
                "bancontact",
                "bank-transfer",
                "credit-card",
                "google-pay",
                "ideal",
                "klarna-direct-debit",
                "klarna-pay-later",
                "klarna-pay-now",
                "payconiq",
                "paypal",
                "sepa-direct-debit",
                "sofort"
            ]
        );
    }
}