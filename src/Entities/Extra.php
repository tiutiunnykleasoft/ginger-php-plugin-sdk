<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;

class Extra implements MultiFieldsEntityInterface
{
    use FieldsValidatorTrait;
    use MultiFieldsEntityTrait {
        toArray as private defaultToArray;
    }

    private string $platform_name;
    private string $platform_version;
    private string $plugin_name;
    private string $plugin_version;
    private string $user_agent;
    private array $additional_fields = [];
    private array $fields;

    public function __construct()
    {
        $this->fields = [
            'platform_name' => false,
            'platform_version' => false,
            'plugin_name' => false,
            'plugin_version' => false,
            'user_agent' => false,
        ];
    }

    public function toArray(): array
    {
        return array_merge(
            $this->defaultToArray(),
            $this->getAllAdditionalFields()
        );
    }

    public function setUserAgent(string $agent): Extra
    {
        $this->user_agent = $agent;
        return $this;
    }

    public function getUserAgent(): string
    {
        return $this->user_agent;
    }

    public function setPlatformName(string $name): Extra
    {
        $this->platform_name = $name;
        return $this;
    }

    public function getPlatformName(): string
    {
        return $this->platform_name;
    }

    public function setPlatformVersion(string $version): Extra
    {
        $this->platform_version = $version;
        return $this;
    }

    public function getPlatformVersion(): string
    {
        return $this->platform_version;
    }

    public function setPluginName(string $name): Extra
    {
        $this->plugin_name = $name;
        return $this;
    }

    public function getPluginName(): string
    {
        return $this->plugin_name;
    }

    public function setPluginVersion(string $version): Extra
    {
        $this->plugin_version = $version;
        return $this;
    }

    public function getPluginVersion(): string
    {
        return $this->plugin_version;
    }

    public function setAdditionalField($name, $value): Extra
    {
        if (!in_array($name, $this->additional_fields)) {
            $this->additional_fields[] = $name;
        }
        $this->$name = $value;
        return $this;
    }

    public function getAdditionalField($name)
    {
        return $this->$name;
    }

    public function getAllAdditionalFields()
    {
        $additional = [];
        foreach ($this->additional_fields as $field) {
            $additional[$field] = $this->$field;
        }
        return $additional;
    }
}