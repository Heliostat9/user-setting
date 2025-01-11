<?php

namespace App\Repositories;

use App\Models\VerificationAttempt;

interface VerificationAttemptRepositoryInterface
{
    /**
     * Сохранить код верификации.
     *
     * @param int $userId Идентификатор пользователя.
     * @param string $code Код верификации.
     * @param string $method Метод доставки (SMS, email, Telegram).
     * @param int $settingId Идентификатор настройки
     *
     * @return void
     */
    public function storeCode(int $userId, string $code, string $method, int $settingId): void;

    /**
     * Проверить, является ли код действительным.
     *
     * @param int    $userId Идентификатор пользователя.
     * @param string $code   Код верификации.
     *
     * @return VerificationAttempt|null
     */
    public function validateCode(int $userId, string $code): ?VerificationAttempt;
}
