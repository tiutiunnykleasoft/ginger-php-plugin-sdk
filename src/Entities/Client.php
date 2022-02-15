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

    protected string $propertyName = 'client';
    private BaseField $user_agent;
    private BaseField $platformName;
    private BaseField $platformVersion;
    private BaseField $pluginName;
    private BaseField $pluginVersion;

    /**
     * @param string $user_agent - HTTP user agent
     * @param string $platformName - Name of the software used to connect to the API, e.g. Magento Community Edition
     * @param string $platformVersion - Version of the software used to connect to the API, e.g. 1.9.2.2
     * @param string $pluginName - Name of the plugin used to connect to the API, e.g. ginger-magento
     * @param string $pluginVersion - Version of the plugin used to connect to the API, e.g. 1.0.0
     */
    public function __construct(
        string $user_agent,
        string $platformName,
        string $platformVersion,
        string $pluginName,
        string $pluginVersion
    )
    {
        $this->user_agent = $this->createSimpleField(
            propertyName: 'user_agent',
            value: $user_agent
        );
        $this->platformName = $this->createSimpleField(
            propertyName: 'platform_name',
            value: $platformName
        );
        $this->platformVersion = $this->createSimpleField(
            propertyName: 'platform_version',
            value: $platformVersion
        );
        $this->pluginName = $this->createSimpleField(
            propertyName: 'plugin_name',
            value: $pluginName
        );
        $this->pluginVersion = $this->createSimpleField(
            propertyName: 'plugin_version',
            value: $pluginVersion
        );
    }

    #[Pure] public function getUserAgent(): string
    {
        return $this->user_agent->get();
    }

    #[Pure] public function getPlatformName(): string
    {
        return $this->pluginName->get();
    }

    #[Pure] public function getPlatformVersion(): string
    {
        return $this->platformVersion->get();
    }

    #[Pure] public function getPluginName(): string
    {
        return $this->pluginName->get();
    }

    #[Pure] public function getPluginVersion(): string
    {
        return $this->pluginVersion->get();
    }
}