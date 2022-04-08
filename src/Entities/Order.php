<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Collections\OrderLines;
use GingerPluginSdk\Collections\Transactions;
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

    private BaseField $merchantOrderId;
    private BaseField $amount;
    private BaseField $webhookUrl;
    private BaseField $returnUrl;
    private BaseField $description;
    private ?Extra $extra;
    private ?Client $client;


    public function __construct(
        private Currency     $currency,
        float|int            $amount,
        private Transactions $transactions,
        private Customer     $customer,
        private ?OrderLines  $orderLines = null,
        ?string              $returnUrl = null,
        ?string              $webhookUrl = null,
        ?string              $merchantOrderId = null,
        ?string              $description = null,
        ?Extra               $extra = null,
        ?Client              $client = null
    )
    {
        $this->amount = $this->createSimpleField(
            propertyName: 'amount',
            value: $this->calculateValueInCents($amount)
        );
        $this->setWebhookUrl($webhookUrl)
            ->setMerchantOrderId($merchantOrderId)
            ->setReturnUrl($returnUrl)
            ->setDescription($description)
            ->setExtra($extra)
            ->setClient($client);
    }

    public function getClient(): array
    {
        return $this->client?->toArray();
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
        return $this->orderLines?->get();
    }

    #[Pure] public function getReturnUrl(): string
    {
        return $this->returnUrl->get();
    }

    #[Pure] public function getWebhookUrl(): string
    {
        return $this->webhookUrl->get();
    }

    #[Pure] public function getMerchantOrderId(): string
    {
        return $this->merchantOrderId->get();
    }

    #[Pure] public function getExtra(): array
    {
        return $this->extra?->toArray();
    }

    #[Pure] public function getDescription(): string
    {
        return $this->description->get();
    }

    public function setClient(?Client $client): Order
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @param string|null $id_string
     * @return $this
     */
    public function setMerchantOrderId(?string $id_string): Order
    {
        $this->merchantOrderId = $this->createSimpleField(
            propertyName: 'merchant_order_id',
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
        $this->webhookUrl = $this->createSimpleField(
            propertyName: 'webhook_url',
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
        $this->returnUrl = $this->createSimpleField(
            propertyName: 'return_url',
            value: $url
        );
        return $this;
    }

    /**
     * @param OrderLines $lines
     * @return $this
     */
    public function setOrderLines(OrderLines $lines): Order
    {
        $this->orderLines = $lines;
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
            propertyName: 'description',
            value: $description
        );
        return $this;
    }
}