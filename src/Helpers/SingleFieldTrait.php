<?php

namespace GingerPluginSdk\Helpers;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Exceptions\OutOfDiapasonException;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;
use JetBrains\PhpStorm\Pure;

trait SingleFieldTrait
{
    protected function createSimpleField($property_name, $value): BaseField
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

    protected function createEnumeratedField($property_name, $value, $enum): ValidateFieldsInterface|BaseField
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

    protected function createFieldWithDiapasonOfValues(string $property_name, mixed $value, int $min, int $max = null): ValidateFieldsInterface|BaseField
    {
        $new_class = new class($property_name, $value, $min, $max) extends BaseField implements ValidateFieldsInterface {
            use FieldsValidatorTrait;

            private int $min;
            private ?int $max;

            #[Pure] public function __construct($property_name, $value, $min, $max)
            {
                $this->min = $min;
                $this->max = $max;
                parent::__construct($property_name);
            }

            public function validate($value)
            {
                if ($value < $this->min) throw new OutOfDiapasonException($this->getPropertyName(), $value, $this->min);
                if ($this->max && $value > $this->max) throw new OutOfDiapasonException($this->getPropertyName(), $value, $this->min, $this->max);
            }
        };
        $new_class->set($value);
        return $new_class;
    }
}