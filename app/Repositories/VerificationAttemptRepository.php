<?php

namespace App\Repositories;

use App\Models\VerificationAttempt;

class VerificationAttemptRepository implements VerificationAttemptRepositoryInterface
{
    public function storeCode(int $userId, string $code, string $method, int $settingId): void
    {
        VerificationAttempt::create(
            [
                'user_id' => $userId,
                'code' => $code,
                'method' => $method,
                'pending_setting_id' => $settingId,
                'expires_at' => now()->addMinutes(10),
            ]
        );
    }

    public function validateCode(int $userId, string $code): ?VerificationAttempt
    {
        return VerificationAttempt::where('user_id', $userId)
            ->where('code', $code)
            ->where('expires_at', '>=', now())
            ->first();
    }
}
