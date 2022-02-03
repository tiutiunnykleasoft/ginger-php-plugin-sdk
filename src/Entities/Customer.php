<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use JetBrains\PhpStorm\Pure;

class Customer implements MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;
    use FieldsValidatorTrait;

    private array $fields;

    public function __construct(
        private ?Address $address = null,
        private array $phone_numbers = [],
        private ?string $merchant_customer_id = null,
        private ?string $email_address = null,
        private ?string $first_name = null,
        private ?string $last_name = null,
        private ?string $address_type = null,
        private ?string $postal_code = null,
        private ?string $housenumber = null,
        private ?string $country = null,
        private ?string $locale = null,
        private ?string $ip_address = null,
        private ?string $gender = null,
        private ?string $birthdate = null,
        private ?string $address_line = null,
    ) {
        $this->address = $this->address ?? new Address();
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
    #[Pure] public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    #[Pure] public function getLastName(): ?string
    {
        return $this->last_name;
    }

    #[Pure] public function getEmailAddress(): ?string
    {
        return $this->email_address;
    }

    #[Pure] public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getAddressType(): ?string
    {
        return $this->address_type;
    }

    #[Pure] public function getBirthdate(): ?string
    {
        return $this->birthdate;
    }

    public function getHousenumber(): ?string
    {
        return $this->housenumber;
    }

    #[Pure] public function getGender(): ?string
    {
        return $this->gender;
    }

    #[Pure] public function getLocale(): ?string
    {
        return $this->locale;
    }

    #[Pure] public function getIpAddress(): ?string
    {
        return $this->ip_address;
    }

    #[Pure] public function getMerchantCustomerId(): ?string
    {
        return $this->merchant_customer_id;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    /**
     * @return string[]
     */
    public function getPhoneNumbers(): array
    {
        return $this->phone_numbers;
    }

    /**
     * @TODO: The last 4 methods is not proofed, just a mock. Take a look!
     * @param \GingerPluginSdk\Entities\Address $address
     */
    #[Pure] public function getAddressLine(): ?string
    {
        return $this->address_line;
    }

    #[Pure] public function getAddress(): Address
    {
        return $this->address;
    }

}