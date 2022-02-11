<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use JetBrains\PhpStorm\Pure;

final class Client implements MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;
    use SingleFieldTrait;

    protected string $property_name = 'client';
    private BaseField $user_agent;
    private BaseField $platform_name;
    private BaseField $platform_version;
    private BaseField $plugin_name;
    private BaseField $plugin_version;

    /**
     * @param string $user_agent - HTTP user agent
     * @param string $platform_name - Name of the software used to connect to the API, e.g. Magento Community Edition
     * @param string $platform_version - Version of the software used to connect to the API, e.g. 1.9.2.2
     * @param string $plugin_name - Name of the plugin used to connect to the API, e.g. ginger-magento
     * @param string $plugin_version - Version of the plugin used to connect to the API, e.g. 1.0.0
     */
    public function __construct(
        string $user_agent,
        string $platform_name,
        string $platform_version,
        string $plugin_name,
        string $plugin_version
    )
    {
        $this->user_agent = $this->createSimpleField(
            property_name: 'user_agent',
            value: $user_agent
        );
        $this->platform_name = $this->createSimpleField(
            property_name: 'platform_name',
            value: $platform_name
        );
        $this->platform_version = $this->createSimpleField(
            property_name: 'platform_version',
            value: $platform_version
        );
        $this->plugin_name = $this->createSimpleField(
            property_name: 'plugin_name',
            value: $plugin_name
        );
        $this->plugin_version = $this->createSimpleField(
            property_name: 'plugin_version',
            value: $plugin_version
        );
    }

    #[Pure] public function getUserAgent(): string
    {
        return $this->user_agent->get();
    }

    #[Pure] public function getPlatformName(): string
    {
        return $this->plugin_name->get();
    }

    #[Pure] public function getPlatformVersion(): string
    {
        return $this->platform_version->get();
    }

    #[Pure] public function getPluginName(): string
    {
        return $this->plugin_name->get();
    }

    #[Pure] public function getPluginVersion(): string
    {
        return $this->plugin_version->get();
    }
}