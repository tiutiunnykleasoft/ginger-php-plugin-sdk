<?php

namespace GingerPluginSdk\Entities;

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
        self::expectException(InvalidDateOfBirth::class);
        $dateOfBirth = new DateOfBirth('dikkerhoer');
    }
}
