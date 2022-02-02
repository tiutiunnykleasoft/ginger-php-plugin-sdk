<?php

namespace GingerPluginSdk\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class NotInTypeException extends Exception
{
    #[Pure] public function __construct($property, $supported_types)
    {
        $message = sprintf('Property %s has incorrect type, supported types is : {%s}', $property, ...$supported_types);
        parent::__construct($message);
    }
}