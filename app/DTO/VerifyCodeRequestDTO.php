<?php

namespace App\DTO;

class VerifyCodeRequestDTO
{
    public string $userId;
    public string $code;

    public function __construct(string $userId, string $code)
    {
        $this->userId = $userId;
        $this->code = $code;
    }
}
