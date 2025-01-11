<?php

namespace App\Repositories;

interface UserSettingRepositoryInterface
{
    /**
     * Обновить или создать пользовательскую настройку.
     *
     * @param int $userId Идентификатор пользователя.
     * @param string $key Ключ настройки.
     * @param string $value Значение настройки.
     * @return void
     */
    public function updateSetting(int $userId, string $key, string $value): void;

    /**
     * Сохранить временную пользовательскую настройку
     *
     * @param string $key Ключ настройки.
     * @param string $value Значение настройки.
     *
     * @return int
     */
    public function saveSetting(string $key, string $value): int;
}
