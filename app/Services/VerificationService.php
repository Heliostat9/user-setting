<?php

namespace App\Services;

use App\DTO\VerifyCodeRequestDTO;
use App\Models\PendingSetting;
use App\Models\UserSetting;
use App\Repositories\VerificationAttemptRepositoryInterface;
use App\Notifications\VerificationNotification;
use Illuminate\Support\Facades\Notification;

class VerificationService implements VerificationServiceInterface
{
    protected VerificationAttemptRepositoryInterface $verificationAttemptRepository;

    public function __construct(VerificationAttemptRepositoryInterface $verificationAttemptRepository)
    {
        $this->verificationAttemptRepository = $verificationAttemptRepository;
    }

    public function generateVerificationCode(string $userId, string $method, int $settingId): string
    {
        $code = rand(100000, 999999);
        $this->verificationAttemptRepository->storeCode($userId, $code, $method, $settingId);
        return $code;
    }

    public function verifyCode(VerifyCodeRequestDTO $dto): bool
    {
        $verificationAttempt = $this->verificationAttemptRepository->validateCode(
            $dto->userId,
            $dto->code
        );

        if (!$verificationAttempt) {
            return false;
        }

        $pendingSetting = PendingSetting::find($verificationAttempt->pending_setting_id);

        if ($pendingSetting) {
            UserSetting::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'key' => $pendingSetting->key
                ],
                ['value' => $pendingSetting->value]
            );

            $pendingSetting->delete();
        }

        $verificationAttempt->delete();

        return true;
    }

    public function sendNotification(string $userId, string $method, string $code): void
    {
        $notification = new VerificationNotification($code, $method);
        Notification::route($method, [])->notify($notification);
    }
}
