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

    protected string $propertyName = '';
    private BaseField $paymentMethod;
    private MultiFieldsEntityInterface $paymentMethodDetails;

    /**
     * @param string $paymentMethod
     * @param PaymentMethodDetails|null $paymentMethodDetails
     */
    public function __construct(string $paymentMethod, PaymentMethodDetails $paymentMethodDetails = null)
    {
        $this->paymentMethod = $this->createEnumeratedField(
            propertyName: 'payment_method',
            value: $paymentMethod,
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
        $this->paymentMethodDetails = $paymentMethodDetails ?: new PaymentMethodDetails();
    }

    public function getPaymentMethodDetails(): PaymentMethodDetails|MultiFieldsEntityInterface
    {
        return $this->paymentMethodDetails;
    }

    public function getPaymentMethod(): ValidateFieldsInterface|BaseField
    {
        return $this->paymentMethod;
    }
}