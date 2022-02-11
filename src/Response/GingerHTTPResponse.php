<?php

namespace GingerPluginSdk\Response;

use JetBrains\PhpStorm\ArrayShape;

final class GingerHTTPResponse
{
    public function __construct(
        private bool                   $status,
        private GingerHTTPResponseBody $body
    )
    {
    }

    #[ArrayShape(['status' => "bool", 'body' => "array"])] public function toArray(): array
    {
        return [
            'status' => $this->status,
            'body' => $this->body->toArray()
        ];
    }
}

