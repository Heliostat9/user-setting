# Для запуска проекта

1. composer install
2. ./vendor/bin/sail up
3. cp .env.example .env
4. php artisan key:generate

Следующие команды запускать в контейнере 
1. php artisan migrate
2. npm install
3. npm run dev
4. ./vendor/bin/sail php artisan queue:work
