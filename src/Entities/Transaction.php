<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Collections\AbstractCollection;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;
use phpDocumentor\Reflection\Types\This;

final class Transaction implements MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;
    use SingleFieldTrait;

    private BaseField $payment_method;
    private MultiFieldsEntityInterface $payment_method_details;

    /**
     * @param string $payment_method
     * @param \GingerPluginSdk\Entities\PaymentMethodDetails|null $payment_method_details
     */
    public function __construct(string $payment_method, PaymentMethodDetails $payment_method_details = null)
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
                "ideal" => true,
                "klarna-direct-debit",
                "klarna-pay-later",
                "klarna-pay-now",
                "payconiq",
                "paypal",
                "sepa-direct-debit",
                "sofort"
            ]
        );
        $this->payment_method_details = $payment_method_details ?: new PaymentMethodDetails();
    }

    public function getPaymentMethodDetails(): PaymentMethodDetails|MultiFieldsEntityInterface
    {
        return $this->payment_method_details;
    }

    public function getPaymentMethod(): ValidateFieldsInterface|BaseField
    {
        return $this->payment_method;
    }
}