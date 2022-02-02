<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Collections\AbstractCollection;
use GingerPluginSdk\Exceptions\LackOfRequiredFieldsException;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Helpers\HelperTrait;
use GingerPluginSdk\Entities\Extra;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;

class Order implements MultiFieldsEntityInterface
{
    use HelperTrait;
    use MultiFieldsEntityTrait;
    use FieldsValidatorTrait;

    private string $merchant_order_id;
    private int $amount;
    private string $description;
    private array $fields;
    private string $webhook_url;
    private string $return_url;
    private Extra $extra;
    private AbstractCollection $order_lines;
    private Customer $customer;

    public function __construct()
    {
        $this->fields = [
            "amount" => true,             // Amount in cents
            "transactions" => false,       // Transactions Array
            "webhook_url" => false,        // Webhook URL
            "customer" => true,           // Customer information
            'currency' => false,          // Currency
            'merchant_order_id' => false, // Merchant Order Id
            'description' => false,       // Description
            'order_lines' => false,       // Order Lines
            'return_url' => false,        // Return URL
            'extra' => false,             // Extra information
        ];
    }

    public function setCustomer(Customer $customer): static
    {
        $this->customer = $customer;
        return $this;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setOrderLines($lines): Order
    {
        $this->order_lines = $lines;
        return $this;
    }

    public function getOrderLines(): AbstractCollection
    {
        return $this->order_lines;
    }

    public function setExtra(Extra $extra): Order
    {
        $this->extra = $extra;
        return $this;
    }

    public function getExtra(): Extra
    {
        return $this->extra;
    }

    public function setReturnUrl($url): Order
    {
        $this->return_url = $url;
        return $this;
    }

    public function getReturnUrl(): string
    {
        return $this->return_url;
    }

    public function setWebhookUrl($url): Order
    {
        $this->webhook_url = $url;
        return $this;
    }

    public function getWebhookUrl(): string
    {
        return $this->webhook_url;
    }

    public function setMerchantOrderId(string $id_string): Order
    {
        $this->merchant_order_id = $id_string;
        return $this;
    }

    public function getMerchantOrderId(): string
    {
        return $this->merchant_order_id;
    }


    public function setAmount(int $amount): Order
    {
        $this->amount = $this->calculateValueInCents($amount);
        return $this;
    }

    public function getAmount(): int|bool
    {
        return $this->amount ?? false;
    }

    public function setDescription(string $description): Order
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}