<?php

namespace GingerPluginSdk\Properties;

class ClientOptions
{
    public string $endpoint;

    public function setEndpoint(string $string)
    {
        $this->endpoint = $string;
    }

    public bool $useBundle;

    public function setUseBundle(bool $use)
    {
        $this->useBundle = $use;
    }

    public string $apiKey;

    public function setApiKey(string $key)
    {
        $this->apiKey = $key;
    }
}