<?php

namespace GingerPluginSdk\Entities;

use Exception;
use GingerPluginSdk\Exceptions\OutOfEnumException;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Helpers\HelperTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;

class Line implements MultiFieldsEntityInterface
{
    use HelperTrait;
    use MultiFieldsEntityTrait;
    use FieldsValidatorTrait;

    /**
     * 'name' => $product->getLabel(),
     * 'amount' => $this->getAmountInCents($product->getUnitPrice()),
     * 'quantity' => (int)$product->getQuantity(),
     * 'vat_percentage' => (int)$this->getAmountInCents($this->calculateTax($product->getPrice()->getCalculatedTaxes()->getElements())),
     * 'merchant_order_line_id' => (string)$product->getProductId(),
     * 'type' => 'physical',
     * 'currency' => $currency,
     */
    private string $name;
    private int $amount;
    private int $quantity;
    private int $vat_percentage;
    private string $merchant_order_line_id;
    private string $type;
    private string $currency;
    private array $acceptable_types;
    private array $fields;
    private int $discount_rate;
    /** @var string Item product page URI */
    private string $url;

    public function __construct()
    {
        $this->fields = [];

        $this->acceptable_types = [
            "physical",
            "discount",
            "shipping_fee",
            "sales_tax",
            "digital",
            "gift_card",
            "store_credit",
            "surcharge"
        ];

        $this->fields = [
            "type" => true,
            "merchant_order_line_id" => true,
            "name" => true,
            "quantity" => true,
            "amount" => true,
            "vat_percentage" => true,
            "currency" => true,
            "image_url" => false,
            "discount_rate" => false,
            "url" => false
        ];
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @param int $vat_percentage
     * @return Line
     */
    public function setVatPercentage(int $vat_percentage): Line
    {
        $this->vat_percentage = $this->calculateValueInCents($vat_percentage);
        return $this;
    }

    /**
     * @return int
     */
    public function getVatPercentage(): int
    {
        return $this->vat_percentage;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getMerchantOrderLineId(): string
    {
        return $this->merchant_order_line_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param float $amount
     * @return \GingerPluginSdk\Entities\Line
     */
    public function setAmount(float $amount): Line
    {
        $this->amount = $this->calculateValueInCents($amount);
        return $this;
    }

    /**
     * @param string $currency
     * @return \GingerPluginSdk\Entities\Line
     */
    public function setCurrency(string $currency): Line
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @param string $merchant_order_id
     * @return \GingerPluginSdk\Entities\Line
     */
    public function setMerchantOrderLineId(string $merchant_order_id): Line
    {
        $this->merchant_order_line_id = $merchant_order_id;
        return $this;
    }

    /**
     * @param string $name
     * @return \GingerPluginSdk\Entities\Line
     */
    public function setName(string $name): Line
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param int $quantity
     * @return \GingerPluginSdk\Entities\Line
     */
    public function setQuantity(int $quantity): Line
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @param string $type
     * @return \GingerPluginSdk\Entities\Line
     * @throws \Exception
     */
    public function setType(string $type): Line
    {
        if (!in_array($type, $this->acceptable_types)) {
            throw new OutOfEnumException('type', $type, json_encode($this->acceptable_types));
        }
        $this->type = $type;
        return $this;
    }
}