<?php

namespace GingerPluginSdk\Properties;

class ClientOptions
{
    /**
     * @param string $endpoint
     * @param bool $useBundle
     * @param string $apiKey
     */
    public function __construct(
        public string $endpoint,
        public bool   $useBundle,
        public string $apiKey
    )
    {
    }
}