<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;

final class Transaction implements MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;
    use SingleFieldTrait;

    protected string $propertyName = '';
    private BaseField $paymentMethod;
    private MultiFieldsEntityInterface $paymentMethodDetails;
    private BaseField $id;
    private BaseField $merchant_id;
    private BaseField $created;
    private BaseField $modified;
    private BaseField $completed;
    private BaseField $settled;
    private BaseField $finalized;
    private BaseField $expirationPeriod;

    /**
     * @param string $paymentMethod
     * @param PaymentMethodDetails|null $paymentMethodDetails
     * @param string|null $id
     * @param string|null $merchantId
     * @param string|null $created
     * @param string|null $modified
     * @param string|null $completed
     * @param string|null $settled
     * @param string|null $finalized
     * @param string|null $expirationPeriod
     */
    public function __construct(
        string               $paymentMethod,
        PaymentMethodDetails $paymentMethodDetails = null,
        ?string              $id = null,
        ?string              $merchantId = null,
        ?string              $created = null,
        ?string              $modified = null,
        ?string              $completed = null,
        ?string              $settled = null,
        ?string              $finalized = null,
        ?string              $expirationPeriod = null
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

        if ($created) $this->created = $this->createFieldInDateTimeISO8601(
            propertyName: 'created',
            value: $created
        );

        if ($modified) $this->modified = $this->createFieldInDateTimeISO8601(
            propertyName: 'modified',
            value: $modified
        );

        if ($completed) $this->modified = $this->createFieldInDateTimeISO8601(
            propertyName: 'completed',
            value: $completed
        );

        if ($settled) $this->modified = $this->createFieldInDateTimeISO8601(
            propertyName: 'settled',
            value: $settled
        );

        if ($finalized) $this->modified = $this->createFieldInDateTimeISO8601(
            propertyName: 'finalized',
            value: $finalized
        );

        if ($expirationPeriod) $this->modified = $this->createFieldInDateTimeISO8601(
            propertyName: 'expiration_period',
            value: $expirationPeriod
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