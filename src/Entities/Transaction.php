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
    private BaseField $id;
    private BaseField $merchant_id;

    /**
     * @param string $paymentMethod
     * @param PaymentMethodDetails|null $paymentMethodDetails
     * @param string|null $id
     */
    public function __construct(
        string               $paymentMethod,
        PaymentMethodDetails $paymentMethodDetails = null,
        ?string              $id = null,
        ?string              $merchantId = null
    )
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
        $this->paymentMethodDetails = $paymentMethodDetails ?: new PaymentMethodDetails();

        if ($id) $this->id = $this->createSimpleField(
            'id',
            $id
        );

        if ($merchantId) $this->merchant_id = $this->createSimpleField(
            'merchant_id',
            $merchantId
        );
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