<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Exceptions\OutOfPatternException;
use GingerPluginSdk\Properties\DateOfBirth;
use PHPUnit\Framework\TestCase;

class DateOfBirthTest extends TestCase
{
    public function test_allows_valid_date()
    {
        $dateOfBirth = new DateOfBirth('2020-01-01');

        self::assertSame('2020-01-01', (string)$dateOfBirth);
    }

    public function test_disallows_invalid_date()
    {
        self::expectException(OutOfPatternException::class);
        $dateOfBirth = new DateOfBirth('not-a-date');
    }

    public function test_get_property()
    {
        self::assertSame(
            (new DateOfBirth("2021-08-09"))->getPropertyName(),
            'birthdate'
        );
    }
}