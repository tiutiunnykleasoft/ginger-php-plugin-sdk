<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Helpers\HelperTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use GingerPluginSdk\Properties\Currency;
use JetBrains\PhpStorm\Pure;

class Order implements MultiFieldsEntityInterface
{
    use HelperTrait;
    use MultiFieldsEntityTrait;
    use FieldsValidatorTrait;
    use SingleFieldTrait;

    private string $property_name = 'order';
    private BaseField $merchant_order_id;
    private BaseField $amount;
    private BaseField $webhook_url;
    private BaseField $return_url;
    private BaseField $description;
    private ?Extra $extra;


    public function __construct(
        private Currency     $currency,
        int                  $amount,
        private Transactions $transactions,
        private Customer     $customer,
        private ?OrderLines  $order_lines = null,
        ?string              $return_url = null,
        ?string              $webhook_url = null,
        ?string              $merchant_order_id = null,
        ?string              $description = null,
        ?Extra               $extra = null
    )
    {
        $this->amount = $this->createSimpleField(
            property_name: 'amount',
            value: $this->calculateValueInCents($amount)
        );
        $this->setWebhookUrl($webhook_url)
            ->setMerchantOrderId($merchant_order_id)
            ->setReturnUrl($return_url)
            ->setDescription($description)
            ->setExtra($extra);
    }

    public function getCustomer(): array
    {
        return $this->customer->toArray();
    }

    #[Pure] public function getAmount(): int
    {
        return $this->amount->get();
    }

    public function getOrderLines(): ?OrderLines
    {
        return $this->order_lines->get();
    }

    #[Pure] public function getReturnUrl(): string
    {
        return $this->return_url->get();
    }

    #[Pure] public function getWebhookUrl(): string
    {
        return $this->webhook_url->get();
    }

    #[Pure] public function getMerchantOrderId(): string
    {
        return $this->merchant_order_id->get();
    }

    #[Pure] public function getExtra(): array
    {
        return $this->extra->toArray();
    }

    #[Pure] public function getDescription(): string
    {
        return $this->description->get();
    }

    /**
     * @param string|null $id_string
     * @return $this
     */
    public function setMerchantOrderId(?string $id_string): Order
    {
        $this->merchant_order_id = $this->createSimpleField(
            property_name: 'merchant_order_id',
            value: $id_string
        );
        return $this;
    }

    /**
     * @param string|null $url
     * @return $this
     */
    public function setWebhookUrl(?string $url): Order
    {
        $this->webhook_url = $this->createSimpleField(
            property_name: 'webhook_url',
            value: $url
        );
        return $this;
    }

    /**
     * @param string|null $url
     * @return $this
     */
    public function setReturnUrl(?string $url): Order
    {
        $this->return_url = $this->createSimpleField(
            property_name: 'return_url',
            value: $url
        );
        return $this;
    }

    /**
     * @param \GingerPluginSdk\Entities\OrderLines $lines
     * @return $this
     */
    public function setOrderLines(OrderLines $lines): Order
    {
        $this->order_lines = $lines;
        return $this;
    }

    /**
     * @param \GingerPluginSdk\Entities\Extra|null $extra
     * @return $this
     */
    public function setExtra(?Extra $extra): Order
    {
        $this->extra = $extra;
        return $this;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): Order
    {
        $this->description = $this->createSimpleField(
            property_name: 'description',
            value: $description
        );
        return $this;
    }
}