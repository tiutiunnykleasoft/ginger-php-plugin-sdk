<?php
namespace GingerPluginSdk\Helpers;

trait orderHelperTrait
{
    public function calculateValueInCents(int $value): int
    {
        return round((float)$value * 100);
    }
}