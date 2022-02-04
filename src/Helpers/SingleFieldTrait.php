<?php

namespace GingerPluginSdk\Helpers;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;
use JetBrains\PhpStorm\Pure;

trait SingleFieldTrait
{
    public function createSimpleField($property_name, $value): BaseField
    {
        $new_class = new class($property_name) extends BaseField {
            #[Pure] public function __construct($property_name)
            {
                parent::__construct($property_name);
            }
        };
        $new_class->set($value);
        return $new_class;
    }

    public function createEnumeratedField($property_name, $value, $enum): ValidateFieldsInterface|BaseField
    {
        $new_class = new class($property_name, $enum, $value) extends BaseField implements ValidateFieldsInterface {
            use FieldsValidatorTrait;

            #[Pure] public function __construct($property_name, $enum)
            {
                $this->enum = $enum;
                parent::__construct($property_name);
            }

            public function validate($value)
            {
                $this->validateEnum($value);
            }
        };
        $new_class->set($value);
        return $new_class;
    }
}