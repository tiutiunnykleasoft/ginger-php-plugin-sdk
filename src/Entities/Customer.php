<?php

namespace GingerPluginSdk\Entities;

use Cassandra\Date;
use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Collections\AbstractCollection;
use GingerPluginSdk\Entities\Email;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;
use JetBrains\PhpStorm\Pure;
use phpDocumentor\Reflection\Types\This;

class Customer implements MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;
    use FieldsValidatorTrait;
    use SingleFieldTrait;

    private string $property_name = 'customer';
    /** ---Required--- */
    private BaseField $last_name;
    private BaseField $first_name;
    private BaseField $gender;
    /** -------------- */

    /** ---not-nullable--- */
    private string $address;
    private BaseField $address_type;
    private BaseField $country;
    private BaseField $postal_code;
    /** ------------------ */


    private PhoneNumbers|null $phone_numbers = null;
    private BaseField|null $merchant_customer_id = null;
    private BaseField|null $locale = null;
    private BaseField|null $ip_address = null;

    private DateOfBirth|null $birthdate = null;


    /**
     * @param Address $address_object
     * @param string $first_name
     * @param string $last_name
     * @param Email $email_address
     * @param string $gender
     * @param \GingerPluginSdk\Entities\PhoneNumbers|null $phone_numbers
     * @param string|null $merchant_customer_id
     * @param \GingerPluginSdk\Entities\DateOfBirth|null $birthdate
     * @param string|null $locale
     * @param string|null $ip_address
     */
    public function __construct(
        private Address $address_object,
        string          $first_name,
        string          $last_name,
        private Email   $email_address,
        string          $gender,
        ?PhoneNumbers   $phone_numbers = null,
        ?string         $merchant_customer_id = null,
        ?string         $birthdate = null,
        ?string         $locale = null,
    )
    {
        $this->first_name = $this->createSimpleField(
            property_name: 'first_name',
            value: $first_name
        );
        $this->last_name = $this->createSimpleField(
            property_name: 'last_name',
            value: $last_name
        );
        $this->gender = $this->createSimpleField(
            property_name: 'gender',
            value: $gender
        );
        $this->setMerchantCustomerId($merchant_customer_id)
            ->setPhoneNumbers($phone_numbers)
            ->setBirthdate($birthdate)
            ->setLocale($locale)
            ->setIpAddress();
//        $this->country = $this->address_object->getCountry();
//        $this->postal_code = $this->address_object->getPostalCode();
//        $this->address_type = $this->address_object->getAddressType();
//        $this->address = $this->address_object->getAddressLine();
    }


    /** -------------------------------- Reworked ------------------------------- */
    #[Pure] public function getFirstName(): string
    {
        return $this->first_name->get();
    }

    #[Pure] public function getLastName(): string
    {
        return $this->last_name->get();
    }

    #[Pure] public function getEmailAddress(): string
    {
        return $this->email_address->get();
    }

    public function getAdditionalAddress(): array
    {
        return $this->address_object->toArray();
    }

    #[Pure] public function getBirthdate(): string
    {
        return $this->birthdate?->get();
    }

    #[Pure] public function getGender(): string
    {
        return $this->gender?->get();
    }

    #[Pure] public function getLocale(): ?string
    {
        return $this->locale?->get();
    }

    #[Pure] public function getIpAddress(): string
    {
        return $this->ip_address->get();
    }

    #[Pure] public function getMerchantCustomerId(): ?string
    {
        return $this->merchant_customer_id->get();
    }

    #[Pure] public function getPhoneNumbers(): array
    {
        return $this->phone_numbers->toArray();
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setBirthdate(?string $date): static
    {
        $this->birthdate = $date ? new DateOfBirth($date) : null;
        return $this;
    }

    /**
     * @param string $locale
     * @return $this
     */
    public function setLocale(?string $locale): static
    {
        $this->locale = $this->createSimpleField(
            property_name: 'locale',
            value: $locale
        );
        return $this;
    }

    /**
     * @return $this
     */
    public function setIpAddress(): static
    {
        $this->ip_address = $this->createSimpleField(
            property_name: "ip_address",
            value: $_SERVER['REMOTE_ADDR']
        );
        return $this;
    }

    /**
     * @param string|null $id
     * @return $this
     */
    public function setMerchantCustomerId(?string $id): static
    {
        $this->merchant_customer_id = $this->createSimpleField(
            property_name: 'merchant_customer_id',
            value: $id
        );
        return $this;
    }

    /**
     * @param \GingerPluginSdk\Entities\PhoneNumbers $phone_numbers
     * @return \GingerPluginSdk\Entities\Customer
     */
    public function setPhoneNumbers(PhoneNumbers $phone_numbers): static
    {
        $this->phone_numbers = $phone_numbers;
        return $this;
    }
}