<?php

namespace App\DTO;

class UpdateSettingRequestDTO
{
    public string $userId;
    public string $key;
    public string $value;
    public string $method;

    public function __construct(string $userId, string $key, string $value, string $method)
    {
        $this->userId = $userId;
        $this->key = $key;
        $this->value = $value;
        $this->method = $method;
    }
}
