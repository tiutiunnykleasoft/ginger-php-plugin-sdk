<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;

class PaymentMethodDetails implements MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;
    use SingleFieldTrait;

    private string $property_name = 'payment_method_details';
    private BaseField|null $issuer_id = null;

    public function __construct(string ...$attributes)
    {
        foreach ($attributes as $title => $value) {
            $this->$title = $this->createSimpleField(
                property_name: $title,
                value: $value
            );
        }
    }

    /**
     * Set Payment Method Details for Ideal payment method.
     *
     * @param string $issuer
     * @return $this
     */
    public function setPaymentMethodDetailsIdeal(string $issuer): static
    {
        $this->issuer_id = $this->createSimpleField(
            property_name: 'issuer_id',
            value: $issuer
        );
        return $this;
    }
}