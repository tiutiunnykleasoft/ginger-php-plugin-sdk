<?php

namespace GingerPluginSdk\Response;

final class GingerHTTPResponseBody
{
    /**
     * @param string $code
     * @param array|null
     * @param string|null $type
     * @param string|null $message
     */
    public function __construct(
        private string  $code,
        private ?array  $data = null,
        private ?string $type = null,
        private ?string $message = null,

    )
    {

    }

    public function toArray(): ?array
    {
        return array_filter([
            'code' => $this->code,
            'type' => $this->type,
            'message' => $this->message,
            'data' => $this->data
        ]);
    }
}