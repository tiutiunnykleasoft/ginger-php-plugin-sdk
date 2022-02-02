<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Exceptions\OutOfEnumException;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;
use GingerPluginSdk\Bases\BaseField;
use JetBrains\PhpStorm\Pure;

class Address implements MultiFieldsEntityInterface, ValidateFieldsInterface
{
    use FieldsValidatorTrait;
    use MultiFieldsEntityTrait {
        toArray as defaultToArray;
    }

    private array $fields;
    private BaseField $address_type;
    private BaseField $postal_code;
    private BaseField $address;
    private BaseField $housenumber;
    private BaseField $country;
    private BaseField|null $city = null;
    private BaseField|null $street = null;
    private array $acceptable_types;

    #[Pure] public function __construct()
    {
        $this->fields = [
            'address_type' => true,
            'address' => true,
            'postal_code' => true,
            'housenumber' => true,
            'country' => true,
        ];
    }

    /**
     * @param string $address_type
     * @return \GingerPluginSdk\Entities\Address
     */
    public function setAddressType(string $address_type): static
    {
        $this->address_type = new class extends BaseField implements ValidateFieldsInterface {
            use FieldsValidatorTrait;

            #[Pure] public function __construct()
            {
                $this->enum = [
                    "customer",
                    "delivery",
                    "billing"
                ];
                parent::__construct('address_type');
            }

            function validate()
            {
                $this->validateEnum();
            }
        };
        $this->address_type->set($address_type);
        return $this;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getAddressType(): ?string
    {
        return $this->address_type->get();
    }

    /**
     * @param string $postal_code
     * @return \GingerPluginSdk\Entities\Address
     */
    public function setPostalCode(string $postal_code): Address
    {
        $this->postal_code = new class extends BaseField {
            #[Pure] public function __construct()
            {
                parent::__construct('postal_code');
            }
        };
        $this->postal_code->set($postal_code);
        return $this;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getPostalCode(): ?string
    {
        return $this->postal_code->get();
    }

    /**
     * @param string $housenumber
     * @return \GingerPluginSdk\Entities\Address
     */
    public function setHousenumber(string $housenumber): Address
    {
        $this->housenumber = new class extends BaseField {
            #[Pure] public function __construct()
            {
                parent::__construct('housenumber');
            }
        };
        $this->housenumber->set($housenumber);
        return $this;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getHousenumber(): ?string
    {
        return $this->housenumber->get();
    }

    /**
     * @param string|null $country
     * @return \GingerPluginSdk\Entities\Address
     */
    public function setCountry(?string $country): Address
    {
        $this->country = new class extends BaseField implements ValidateFieldsInterface {
            use FieldsValidatorTrait;

            #[Pure] public function __construct()
            {
                parent::__construct('country');
            }

            public function validate()
            {
                $this->validatePattern("/^[a-zA-Z]{2}$/", ['UA,NL,BE,FR']);
            }
        };
        $this->country->set($country);
        return $this;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getCountry(): ?string
    {
        return $this->country->get();
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity(string $city): static
    {
        $this->city = new class extends BaseField {
            #[Pure] public function __construct()
            {
                parent::__construct('city');
            }
        };
        $this->city->set($city);
        return $this;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getCity(): ?string
    {
        return $this->city?->get();
    }

    /**
     * @param string $street
     * @return $this
     */
    public function setStreet(string $street): static
    {
        $this->street = new class extends BaseField {
            #[Pure] public function __construct()
            {
                parent::__construct('street');
            }
        };
        $this->street->set($street);
        return $this;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getStreet(): ?string
    {
        return $this->street?->get();
    }

    /**
     * @return $this
     * @throws \GingerPluginSdk\Exceptions\LackOfRequiredFieldsException
     */
    public function setAddress(): static
    {
        $this->address = new class extends BaseField {
            #[Pure] public function __construct()
            {
                parent::__construct('address');
            }
        };
        $this->address->set($this->generateAddress());
        return $this;
    }

    /**
     * @return string
     * @throws \GingerPluginSdk\Exceptions\LackOfRequiredFieldsException
     */
    public function generateAddress(): string
    {
        $this->validateRequiredFields(['address']);
        return implode(' ', array_filter([
            $this->getStreet(),
            $this->getHousenumber(),
            $this->getPostalCode(),
            $this->getCity(),
        ]));
    }

    /**
     * @return string|null
     */
    #[Pure] public function getAddress(): ?string
    {
        return $this->address->get();
    }

    /**
     * @throws \GingerPluginSdk\Exceptions\LackOfRequiredFieldsException
     */
    public function validate()
    {
        $this->validateRequiredFields();
    }
}