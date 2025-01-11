<?php

namespace App\Http\Controllers;

use App\Services\VerificationServiceInterface;
use App\Services\UserSettingServiceInterface;
use App\Http\Requests\UpdateSettingRequest;
use App\Http\Requests\VerifyCodeRequest;
use Inertia\Inertia;
use Inertia\Response;

class UserSettingController extends Controller
{
    protected VerificationServiceInterface $verificationService;
    protected UserSettingServiceInterface $userSettingService;

    public function __construct(
        VerificationServiceInterface $verificationService,
        UserSettingServiceInterface $userSettingService
    ) {
        $this->verificationService = $verificationService;
        $this->userSettingService = $userSettingService;
    }

    public function updateSetting(UpdateSettingRequest $request): Response
    {
        $dto = $request->toDTO();
        $this->userSettingService->initiateUpdate($dto);
        return Inertia::render('UpdateSetting');
    }

    public function verifyCode(VerifyCodeRequest $request): Response
    {
        $dto = $request->toDTO();
        $isVerify = $this->verificationService->verifyCode($dto);

        if ($isVerify) {
            $response['message'] = 'Настройки успешно обновлены';
            $response['status'] = 'success';
        } else {
            $response['errors'] = ['code' => 'Неверный код подтверждения.'];
            $response['status'] = 'failed';
        }
        return Inertia::render('VerifyCode', $response);
    }
}
