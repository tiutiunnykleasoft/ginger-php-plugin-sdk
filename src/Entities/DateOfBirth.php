<?php

namespace GingerPluginSdk\Entities;


final class DateOfBirth
{
    public function __construct(private string $date)
    {
        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $date);
        if ($date === false || $date->format('Y-m-d') !== $this->date) {
            throw new InvalidDateOfBirth('The provided date of birth the format should be Y-m-d', 0);
        }
    }

    public function __toString(): string
    {
        return $this->date;
    }
}