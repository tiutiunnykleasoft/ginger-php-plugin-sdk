<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Collections\AbstractCollection;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;
use JetBrains\PhpStorm\Pure;

class Customer implements MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;
    use FieldsValidatorTrait;

    private array $fields;
    private Address $address;
    private AbstractCollection|null $phone_numbers = null;
    private BaseField|null $merchant_customer_id = null;
    private BaseField|null $email_address = null;
    private BaseField|null $first_name = null;
    private BaseField|null $last_name = null;
    private string|null $address_type = null;
    private string|null $postal_code = null;
    private string|null $housenumber = null;
    private string|null $country = null;
    private BaseField|null $locale = null;
    private BaseField|null $ip_address = null;
    private BaseField|null $gender = null;
    private BaseField|null $birthdate = null;

    public function __construct()
    {
        $this->address = new Address();
        $this->fields = [
            "merchant_customer_id" => false,
            "email_address" => false,
            "first_name" => false,
            "last_name" => false,
            "address_type" => false,
            "address" => false,
            "postal_code" => false,
            "housenumber" => false,
            "country" => false,
            "locale" => false,
            "phone_numbers" => false,
            "ip_address" => false,
            "gender" => false,
            "birthdate" => false
        ];
    }

    /** -------------------------------- Reworked ------------------------------- */

    /**
     * @param string $name
     * @return $this
     */
    public function setFirstName(string $name): static
    {
        $this->first_name = new class extends BaseField {
            #[Pure] public function __construct()
            {
                parent::__construct('first_name');
            }
        };
        $this->first_name->set($name);

        return $this;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getFirstName(): ?string
    {
        return $this->first_name?->get();
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setLastName(string $name): static
    {
        $this->last_name = new class extends BaseField {
            #[Pure] public function __construct()
            {
                parent::__construct('last_name');
            }
        };
        $this->last_name->set($name);
        return $this;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getLastName(): ?string
    {
        return $this->last_name?->get();
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setEmailAddress(string $address): static
    {
        $this->email_address = new class extends BaseField {
            #[Pure] public function __construct()
            {
                parent::__construct('email_address');
            }
        };
        $this->email_address->set($address);
        return $this;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getEmailAddress(): ?string
    {
        return $this->email_address?->get();
    }

    /**
     * @param string $country
     * @return $this
     */
    public function setCountry(string $country): static
    {
        $this->address->setCountry($country);
        $this->country = $this->address->getCountry();
        return $this;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setAddressType(string $type): static
    {
        $this->address->setAddressType($type);
        $this->address_type = $this->address->getAddressType();
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddressType(): ?string
    {
        return $this->address_type;
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setBirthdate(string $date): static
    {
        $this->birthdate = new class extends BaseField implements ValidateFieldsInterface {

            #[Pure] public function __construct()
            {
                parent::__construct('birthdate');
            }

            public function validate()
            {
                // TODO: Implement validate() method.
            }
        };
        $this->birthdate->set($date);
        return $this;
    }

    /**
     * @return string
     */
    #[Pure] public function getBirthdate(): string
    {
        return $this->birthdate?->get();
    }

    /**
     * @param string $number
     * @return $this
     */
    public function setHousenumber(string $number): static
    {
        $this->address->setHousenumber($number);
        $this->housenumber = $this->address->getHousenumber();
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHousenumber(): ?string
    {
        return $this->housenumber;
    }

    /**
     * @param string $gender
     * @return $this
     */
    public function setGender(string $gender): static
    {
        $this->gender = new class extends BaseField implements ValidateFieldsInterface {

            #[Pure] public function __construct()
            {
                parent::__construct('gender');
            }

            public function validate()
            {
                // TODO: Implement validate() method.
            }
        };
        $this->gender->set($gender);
        return $this;
    }

    /**
     * @return string
     */
    #[Pure] public function getGender(): string
    {
        return $this->gender?->get();
    }

    /**
     * @param string $locale
     * @return $this
     */
    public function setLocale(string $locale): static
    {
        $this->locale = new class extends BaseField implements ValidateFieldsInterface {

            #[Pure] public function __construct()
            {
                parent::__construct('locale');
            }

            public function validate()
            {
                // TODO: Implement validate() method.
            }
        };
        $this->locale->set($locale);
        return $this;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getLocale(): ?string
    {
        return $this->locale?->get();
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setIpAddress(string $address): static
    {
        $this->ip_address = new class extends BaseField {
            #[Pure] public function __construct()
            {
                parent::__construct('ip_address');
            }
        };
        $this->ip_address->set($address);
        return $this;
    }

    /**
     * @return string
     */
    #[Pure] public function getIpAddress(): string
    {
        return $this->ip_address->get();
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setMerchantCustomerId(string $id): static
    {
        $this->merchant_customer_id = new class extends BaseField {
            #[Pure] public function __construct()
            {
                parent::__construct('merchant_customer_id');
            }
        };
        $this->merchant_customer_id->set($id);
        return $this;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getMerchantCustomerId(): ?string
    {
        return $this->merchant_customer_id->get();
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setPostalCode(string $code): static
    {
        $this->address->setPostalCode($code);
        $this->postal_code = $this->address->getPostalCode();
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    /**
     * @param \GingerPluginSdk\Collections\AbstractCollection $phone_numbers
     * @return \GingerPluginSdk\Entities\Customer
     */
    public function setPhoneNumbers(AbstractCollection $phone_numbers): static
    {
        if ($phone_numbers->count() < 1) $phone_numbers = null;
        $this->phone_numbers = $phone_numbers;
        return $this;
    }

    /**
     * @return \GingerPluginSdk\Collections\AbstractCollection|null
     */
    public function getPhoneNumbers(): ?AbstractCollection
    {
        return $this->phone_numbers;
    }

    /**
     * @param \GingerPluginSdk\Entities\Address $address
     * @throws \GingerPluginSdk\Exceptions\LackOfRequiredFieldsException
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address->getAddress() ?? "";
        $this->address_type = $address->getAddressType();
    }

    /** ------------------------------------------------------------------------- */


    public function getAddress(): ?string
    {
        return $this->address;
    }

}