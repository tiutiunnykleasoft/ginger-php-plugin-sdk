<?php

namespace GingerPluginSdk\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class OutOfPatternException extends Exception
{
    public function __construct($property, $valid)
    {
        $message = sprintf('Property `%s` is out of the pattern, valid example for this property : {%s}', $property, json_encode($valid));
        parent::__construct($message);
    }
}