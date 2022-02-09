<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Collections\AbstractCollection;
use GingerPluginSdk\Exceptions\LackOfRequiredFieldsException;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Helpers\HelperTrait;
use GingerPluginSdk\Entities\Extra;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use JetBrains\PhpStorm\Pure;

class Order implements MultiFieldsEntityInterface
{
    use HelperTrait;
    use MultiFieldsEntityTrait;
    use FieldsValidatorTrait;
    use SingleFieldTrait;


    private string $description;
    private array $fields;
    private string $webhook_url;
    private string $return_url;
    private Extra $extra;
    private AbstractCollection $order_lines;

    /** -------------------------------- Reworked ------------------------------- */
    private string $property_name = 'order';
    private BaseField|null $merchant_order_id;
    private BaseField $amount;


    public function __construct(
        int                  $amount,
        private Transactions $transactions,
        private Customer     $customer
    )
    {
        $this->amount = $this->createSimpleField(
            property_name: 'amount',
            value: $this->calculateValueInCents($amount)
        );
    }

    #[Pure] public function getCustomer(): Customer
    {
        return $this->customer;
    }

    #[Pure] public function getAmount(): int
    {
        return $this->amount->get();
    }

    /** ------------------------------------------------------------------------- */


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