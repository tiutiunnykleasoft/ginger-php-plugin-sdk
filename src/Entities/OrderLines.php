<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Collections\AbstractCollection;

final class OrderLines extends AbstractCollection
{
    public function __construct(Line $item)
    {
        $this->property_name = 'order_lines';
        $this->add($item);
        parent::__construct(Line::class, 'order_lines');
    }

    public function addLine(Line $item)
    {
        $this->add($item);
    }

    public function removeLine($index)
    {
        $this->remove($index);
    }
}