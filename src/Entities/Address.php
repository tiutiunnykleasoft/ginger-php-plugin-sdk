<?php

declare(strict_types=1);

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use GingerPluginSdk\Bases\BaseField;
use JetBrains\PhpStorm\Pure;

final class Address implements MultiFieldsEntityInterface
{
    use SingleFieldTrait;
    use MultiFieldsEntityTrait;

    private BaseField $address_type;
    private BaseField $postal_code;
    private BaseField $country;
    private BaseField $city;
    private BaseField $street;
    private BaseField $address;
    private BaseField|null $housenumber = null;
    private array $fields;
    private array $acceptable_types;

    /**
     * @param string $address_type
     * @param string $postal_code
     * @param string $street
     * @param string $city
     * @param \GingerPluginSdk\Entities\Country $country
     */
    public function __construct(
        string  $address_type,
        string  $postal_code,
        string  $street,
        string  $city,
        Country $country
    )
    {
        $this->address_type = $this->createEnumeratedField(
            property_name: 'address_type',
            value: $address_type,
            enum: [
                "customer",
                "delivery",
                "billing"
            ]);
        $this->postal_code = $this->createSimpleField(
            property_name: 'postal_code',
            value: $postal_code
        );
        $this->street = $this->createSimpleField(
            property_name: 'street',
            value: $street
        );
        $this->city = $this->createSimpleField(
            property_name: "city",
            value: $city
        );
        $this->country = $country;
        $this->address = $this->createSimpleField(
            property_name: 'address',
            value: $this->generateAddress()
        );
    }

    #[Pure] public function getAddressType(): BaseField
    {
        return $this->address_type;
    }

    #[Pure] public function getPostalCode(): BaseField
    {
        return $this->postal_code;
    }

    #[Pure] public function getCountry(): BaseField
    {
        return $this->country;
    }

    #[Pure] public function getCity(): BaseField
    {
        return $this->city;
    }

    #[Pure] public function getStreet(): BaseField
    {
        return $this->street;
    }

    #[Pure] public function getHousenumber(): ?BaseField
    {
        return $this->housenumber;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setHousenumber(string $value): static
    {
        $this->housenumber = $this->createSimpleField(
            property_name: 'housenumber',
            value: $value
        );
        $this->setAddressLine();
        return $this;
    }

    public function setAddressLine()
    {
        $this->address = $this->createSimpleField(
            property_name: 'address',
            value: $this->generateAddress()
        );
    }

    #[Pure] public function getAddressLine(): string
    {
        return $this->address->get();
    }

    public function generateAddress(): string
    {
        return implode(' ', array_filter([
            $this->getStreet()->get(),
            $this->getHousenumber()?->get(),
            $this->getPostalCode()->get(),
            $this->getCity()->get(),
        ]));
    }
}