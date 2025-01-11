<?php

namespace App\Repositories;

use App\Models\UserSetting;
use App\Models\PendingSetting;

class UserSettingRepository implements UserSettingRepositoryInterface
{
    public function updateSetting(int $userId, string $key, string $value): void
    {
        UserSetting::updateOrCreate(
            ['user_id' => $userId, 'key' => $key],
            ['value' => $value]
        );
    }

    public function saveSetting(string $key, string $value): int
    {
        $setting = PendingSetting::create(
            [
                'key' => $key,
                'value' => $value,
            ]
        );

        return $setting->id;
    }
}
