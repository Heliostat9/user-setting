<?php

namespace App\Services;

use App\DTO\UpdateSettingRequestDTO;
use App\Repositories\UserSettingRepositoryInterface;

class UserSettingService implements UserSettingServiceInterface
{
    protected UserSettingRepositoryInterface $userSettingRepository;
    protected VerificationServiceInterface $verificationService;

    public function __construct(
        UserSettingRepositoryInterface $userSettingRepository,
        VerificationServiceInterface $verificationService
    ) {
        $this->userSettingRepository = $userSettingRepository;
        $this->verificationService = $verificationService;
    }

    public function initiateUpdate(UpdateSettingRequestDTO $dto): void
    {
        $settingId = $this->userSettingRepository->saveSetting($dto->key, $dto->value);
        $code = $this->verificationService->generateVerificationCode($dto->userId, $dto->method, $settingId);
        $this->verificationService->sendNotification($dto->userId, $dto->method, $code);
    }
}
