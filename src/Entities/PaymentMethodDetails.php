<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;

final class PaymentMethodDetails implements MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;
    use SingleFieldTrait;

    private string $propertyName = 'payment_method_details';
    private BaseField|null $issuer_id = null;

    /**
     * @param string ...$attributes
     */
    public function __construct(string ...$attributes)
    {
        foreach ($attributes as $title => $value) {
            $this->$title = $this->createSimpleField(
                propertyName: $title,
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
    public function setPaymentMethodDetailsIdeal(string $issuer): PaymentMethodDetails
    {
        $this->issuer_id = $this->createSimpleField(
            propertyName: 'issuer_id',
            value: $issuer
        );
        return $this;
    }
}