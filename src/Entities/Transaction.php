<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\HelperTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;
use GingerPluginSdk\Properties\Currency;

final class Transaction implements MultiFieldsEntityInterface
{
    use HelperTrait, SingleFieldTrait, MultiFieldsEntityTrait;

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
    private BaseField $amount;
    private BaseField $balance;
    private BaseField $expiration_period;
    private BaseField $description;
    private BaseField $productType;
    private BaseField $creditDebit;

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
     * @param \GingerPluginSdk\Properties\Currency|null $currency
     * @param float|null $amount
     * @param string|null $balance
     * @param string|null $description
     * @param string|null $productType
     * @param string|null $creditDebit
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
        ?string              $expirationPeriod = null,
        private ?Currency    $currency = null,
        ?float               $amount = null,
        ?string              $balance = null,
        ?string              $description = null,
        ?string              $productType = null,
        ?string              $creditDebit = null
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

        if ($completed) $this->completed = $this->createFieldInDateTimeISO8601(
            propertyName: 'completed',
            value: $completed
        );

        if ($settled) $this->settled = $this->createFieldInDateTimeISO8601(
            propertyName: 'settled',
            value: $settled
        );

        if ($finalized) $this->finalized = $this->createFieldInDateTimeISO8601(
            propertyName: 'finalized',
            value: $finalized
        );

        if ($expirationPeriod) $this->expiration_period = $this->createFieldInDateTimeISO8601(
            propertyName: 'expiration_period',
            value: $expirationPeriod
        );

        if ($amount) $this->amount = $this->createFieldWithDiapasonOfValues(
            propertyName: 'amount',
            value: $this->calculateValueInCents($amount),
            min: 1,
            max: 999999999999
        );

        if ($balance) $this->balance = $this->createEnumeratedField(
            propertyName: 'balance',
            value: $balance,
            enum: [
                "internal",
                "external",
                "test"
            ]
        );

        if ($description) $this->description = $this->createSimpleField(
            propertyName: 'description',
            value: $description
        );

        if ($productType) $this->productType = $this->createSimpleField(
            propertyName: 'product_type',
            value: $productType
        );

        if ($creditDebit) $this->creditDebit = $this->createEnumeratedField(
            propertyName: 'credit_debit',
            value: $creditDebit,
            enum: [
                "credit",
                "debit"
            ]
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