<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Interfaces\AbstractCollectionContainerInterface;
use GingerPluginSdk\Collections\AbstractCollection;
use JetBrains\PhpStorm\Pure;

class Transactions extends AbstractCollection implements AbstractCollectionContainerInterface
{
    private string $property_name = 'transactions';

    public function __construct(Transaction $item)
    {
        $this->add($item);
        parent::__construct($item);
    }

    public function getPropertyName(): string
    {
        return $this->property_name;
    }

    public function addTransaction(Transaction $transaction): static
    {
        $this->add($transaction);
        return $this;
    }

    public function removeTransaction(string $index): static
    {
        $this->remove($index);
        return $this;
    }

    #[Pure] public function getAll(): array
    {
        return $this->getAll();
    }
}