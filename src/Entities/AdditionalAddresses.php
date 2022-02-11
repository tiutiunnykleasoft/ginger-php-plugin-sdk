<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Collections\AbstractCollection;

class AdditionalAddresses extends AbstractCollection
{
    public function __construct(Address $item)
    {
        $this->property_name = 'additional_addresses';
        $this->add($item);
        parent::__construct(Address::class, $this->property_name);
    }

    public function addAddress(Address $item): AdditionalAddresses
    {
        $this->add($item);
        return $this;
    }

    public function removeAddress($index): AdditionalAddresses
    {
        $this->remove($index);
        return $this;
    }
}