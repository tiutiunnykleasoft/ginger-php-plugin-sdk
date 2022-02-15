<?php

namespace GingerPluginSdk\Properties;

use GingerPluginSdk\Entities\Transaction;
use GingerPluginSdk\Interfaces\AbstractCollectionContainerInterface;
use GingerPluginSdk\Collections\AbstractCollection;
use JetBrains\PhpStorm\Pure;

final class Transactions extends AbstractCollection implements AbstractCollectionContainerInterface
{
    public function __construct(Transaction $item)
    {
        $this->propertyName = 'transactions';
        $this->add($item);
        parent::__construct($item, 'transactions');
    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    public function addTransaction(Transaction $transaction): Transactions
    {
        $this->add($transaction);
        return $this;
    }

    public function removeTransaction(string $index): Transactions
    {
        $this->remove($index);
        return $this;
    }

    #[Pure] public function getAll(): array
    {
        return $this->getAll();
    }
}