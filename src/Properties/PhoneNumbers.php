<?php

namespace GingerPluginSdk\Properties;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Collections\AbstractCollection;
use GingerPluginSdk\Helpers\SingleFieldTrait;

final class PhoneNumbers extends AbstractCollection
{
    use SingleFieldTrait;

    public function __construct(string $number)
    {
        $this->property_name = 'phone_numbers';
        $this->add($number);
        parent::__construct(BaseField::class, 'phone_numbers');
    }

    public function addPhoneNumber(BaseField $transaction): static
    {
        $this->add($transaction);
        return $this;
    }

    public function removePhoneNumber(string $index): static
    {
        $this->remove($index);
        return $this;
    }

    public function getAll(): array
    {
        return $this->getAll();
    }
}