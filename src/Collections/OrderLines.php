<?php

namespace GingerPluginSdk\Collections;

use GingerPluginSdk\Collections\AbstractCollection;
use GingerPluginSdk\Entities\Line;

final class OrderLines extends AbstractCollection
{
    public function __construct(Line $item)
    {
        $this->propertyName = 'order_lines';
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