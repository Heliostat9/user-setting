<?php

namespace App\Services;

use App\DTO\VerifyCodeRequestDTO;

interface VerificationServiceInterface
{
    public function generateVerificationCode(string $userId, string $method, int $settingId): string;

    public function verifyCode(VerifyCodeRequestDTO $dto): bool;

    public function sendNotification(string $userId, string $method, string $code): void;
}
