<?php

namespace GingerPluginSdk\Collections;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\SingleFieldTrait;

final class PhoneNumbers extends AbstractCollection
{
    use SingleFieldTrait;

    public function __construct(string ...$numbers)
    {
        $this->propertyName = 'phoneNumbers';

        foreach ($numbers as $number) {
            $this->add($number);
        }

        parent::__construct(BaseField::class, 'phone_numbers');
    }

    public function addPhoneNumber(string $number): PhoneNumbers
    {
        $this->add($number);
        return $this;
    }

    public function removePhoneNumber(string $index): PhoneNumbers
    {
        $this->remove($index);
        return $this;
    }
}