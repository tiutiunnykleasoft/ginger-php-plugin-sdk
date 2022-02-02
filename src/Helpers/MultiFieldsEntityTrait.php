<?php

namespace GingerPluginSdk\Helpers;

use GingerPluginSdk\Exceptions\LackOfRequiredFieldsException;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;

trait MultiFieldsEntityTrait
{
    public function getField($fieldName): mixed
    {
        return $this->$fieldName ?? null;
    }

    /**
     * @throws \GingerPluginSdk\Exceptions\LackOfRequiredFieldsException
     * @TODO: ROLLBACK!!!!!
     */

    public function toArray(): array
    {
        $this->validateRequiredFields();
        $response = [];
        foreach ($this->fields as $field => $required) {
            $requested_field = $this->getField($field);

            if ($requested_field instanceof MultiFieldsEntityInterface) {
                $requested_field = $requested_field->toArray();
                $response[$field] = $requested_field;
            } else {
                if ($field instanceof \stdClass) {
                    $response[$field] = $requested_field?->get();
                } else {
                    $response[$field] = $requested_field;
                }
            }
        }
        return array_filter($response);
    }
}