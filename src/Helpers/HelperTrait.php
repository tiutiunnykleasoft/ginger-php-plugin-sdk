<?php

namespace GingerPluginSdk\Helpers;

use GingerPluginSdk\Exceptions\LackOfRequiredFieldsException;

trait HelperTrait
{
    protected function calculateValueInCents($value): int
    {
        return round((float)$value * 100);
    }
}