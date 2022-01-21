<?php

namespace GingerPluginSdk\Properties;

trait IdTrait
{
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        return $this->id;
    }
}