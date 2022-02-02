<?php

namespace GingerPluginSdk\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class LackOfRequiredFieldsException extends Exception
{
    #[Pure] public function __construct($className, $expected_more)
    {
        $message = sprintf('The object {%s} has a lack of required fields, waiting for : {%s}', $className, $expected_more);
        parent::__construct($message);
    }
}