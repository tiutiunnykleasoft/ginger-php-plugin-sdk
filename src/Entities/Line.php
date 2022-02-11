<?php

namespace GingerPluginSdk\Entities;

use Exception;
use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Exceptions\OutOfEnumException;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Helpers\HelperTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use GingerPluginSdk\Properties\Currency;
use JetBrains\PhpStorm\Pure;

final class Line implements MultiFieldsEntityInterface
{
    use HelperTrait;
    use MultiFieldsEntityTrait;
    use SingleFieldTrait;

    private BaseField $type;
    private BaseField $merchant_order_line_id;
    private BaseField $name;
    private BaseField $quantity;
    private BaseField $amount;
    private BaseField $vat_percentage;
    private BaseField $discount_rate;
    private BaseField $url;

    /**
     * @param string $type - Type: physical, discount, shipping_fee, sales_tax, digital, gift_card, store_credit or surcharge
     * @param string $merchant_order_line_id - Merchant's internal order line identifier
     * @param string $name - Name, usually a short description
     * @param int $quantity
     * @param float $amount - Amount for a single item (including VAT) in cents
     * @param int $vat_percentage - Percentage of tax rate, will be multiplied by 100 and provided as an integer. i.e. 17.50% would be sent as 1750
     * @param Currency|null $currency
     * @param int|null $discount_rate - Percentage of discount, will be multiplied by 100 and provided as an integer. i.e. 11.57% would be sent as 1157
     * @param string|null $url - Item product page URI
     */
    public function __construct(
        string            $type,
        string            $merchant_order_line_id,
        string            $name,
        int               $quantity,
        float             $amount,
        int               $vat_percentage,
        private ?Currency $currency = null,
        ?int              $discount_rate = null,
        ?string           $url = null
    )
    {
        $this->type = $this->createEnumeratedField(
            property_name: 'type',
            value: $type,
            enum: [
                "physical",
                "discount",
                "shipping_fee",
                "sales_tax",
                "digital",
                "gift_card",
                "store_credit",
                "surcharge"
            ]
        );
        $this->merchant_order_line_id = $this->createSimpleField(
            property_name: 'merchant_order_line_id',
            value: $merchant_order_line_id
        );
        $this->name = $this->createSimpleField(
            property_name: 'name',
            value: $name
        );

        $this->quantity = $this->createFieldWithDiapasonOfValues(
            property_name: 'quantity',
            value: $quantity,
            min: 1
        );
        $this->amount = $this->createSimpleField(
            property_name: 'amount',
            value: $this->calculateValueInCents($amount)
        );
        $this->vat_percentage = $this->createFieldWithDiapasonOfValues(
            property_name: 'vat_percentage',
            value: $this->calculateValueInCents($vat_percentage),
            min: 0,
            max: 10000
        );
        $this->setDiscountRate($discount_rate);
        $this->setUrl($url);
    }

    #[Pure] public function getUrl(): ?string
    {
        return $this->url->get();
    }

    #[Pure] public function getVatPercentage(): ?string
    {
        return $this->vat_percentage->get();
    }

    #[Pure] public function getDiscountRate(): ?string
    {
        return $this->discount_rate->get();
    }

    #[Pure] public function getAmount(): int
    {
        return $this->amount->get();
    }

    #[Pure] public function getCurrency(): string
    {
        return $this->currency->get();
    }

    #[Pure] public function getMerchantOrderLineId(): string
    {
        return $this->merchant_order_line_id->get();
    }

    #[Pure] public function getName(): string
    {
        return $this->name->get();
    }

    #[Pure] public function getQuantity(): int
    {
        return $this->quantity->get();
    }

    #[Pure] public function getType(): string
    {
        return $this->type->get();
    }

    /**
     * @param string|null $url
     * @return $this
     */
    public function setUrl(?string $url): Line
    {
        $this->url = $this->createSimpleField(
            property_name: 'url',
            value: $url
        );
        return $this;
    }

    /**
     * @param int|null $value
     * @return $this
     */
    public function setDiscountRate(?int $value): Line
    {
        $this->discount_rate = $this->createFieldWithDiapasonOfValues(
            property_name: 'discount_rate',
            value: $this->calculateValueInCents($value),
            min: 0, max: 10000
        );
        return $this;
    }
}