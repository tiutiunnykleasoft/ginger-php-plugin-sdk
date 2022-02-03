<?php

namespace GingerPluginSdk\Entities;

class Extra
{

    public function __construct(
        private ?string $platform_name = null,
        private ?string $platform_version = null,
        private ?string $plugin_name = null,
        private ?string $plugin_version = null,
        private ?string $user_agent = null,
        private array $additional_fields = [],
        private array $fields = [],
    )
    {
    }

    public function toArray(): array
    {
        return [
            'platform_name' => $this->platform_name,
            'platform_version' => $this->platform_version,
            'plugin_name' => $this->plugin_name,
            'plugin_version' => $this->plugin_version,
            'user_agent' => $this->user_agent,
            'additional_fields' => $this->additional_fields,
            'fields' => $this->fields,
        ];
    }

    public function getUserAgent(): string
    {
        return $this->user_agent;
    }

    public function getPlatformName(): string
    {
        return $this->platform_name;
    }

    public function getPlatformVersion(): string
    {
        return $this->platform_version;
    }

    public function getPluginName(): string
    {
        return $this->plugin_name;
    }

    public function getPluginVersion(): string
    {
        return $this->plugin_version;
    }
}