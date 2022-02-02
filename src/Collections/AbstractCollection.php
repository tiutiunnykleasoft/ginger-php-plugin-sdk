<?php

namespace GingerPluginSdk\Collections;

use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;

/** @template T */
class AbstractCollection implements MultiFieldsEntityInterface
{
    private int $pointer = 0;
    private array $items;

    /**
     * @template T
     * @var T $classname
     */
    public function __construct(mixed $classObj)
    {
    }

    /** @var T $item */
    public function add(mixed $item)
    {
        $this->items[$this->pointer] = $item;
        $this->next();
    }

    /** @return T */
    public function get($position = null)
    {
        return $this->items[$position ?? $this->pointer];
    }

    /** @return array<T> */
    public function getAll(): array
    {
        return $this->items;
    }

    public function getField($fieldName): mixed
    {
        return $this->items[$fieldName] ?? "";
    }

    public function toArray(): array
    {
        $response = [];
        /** @var T $item */
        foreach ($this->items as $item) {
            if (method_exists($item, 'toArray')) {
                $response[] = $item->toArray();
            } else {
                $response[] = $item;
            }
        }
        return $response;
    }

    private function next()
    {
        $this->pointer++;
    }

    private function prev()
    {
        $this->pointer--;
    }

    public function clear()
    {
        $this->items = [];
    }

    public function count(): int
    {
        return $this->pointer;
    }
}