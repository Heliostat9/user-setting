<?php

namespace App\Services;

use App\DTO\UpdateSettingRequestDTO;

interface UserSettingServiceInterface
{
    public function initiateUpdate(UpdateSettingRequestDTO $dto): void;
}
