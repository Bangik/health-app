<?php

namespace App\Dto;

class ResponseApiDto
{
    public function __construct(
        public bool $status,
        public int $code,
        public string $message = '',
        public $data = null,
        public $meta = null,
        public string $dev = '',
    ) {
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data,
            'meta' => $this->meta,
            'dev' => $this->dev,
        ];
    }
}
