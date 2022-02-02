<?php

namespace GingerPluginSdk\Interfaces;

interface MultiFieldsEntityInterface
{
    public function getField($fieldName): mixed;

    public function toArray(): array;
}