# Car Booking - Тестовое задание

```bash
git clone https://github.com/qeaaaae/car-booking-test-task.git
cd car-booking-test-task

# Установить зависимости
composer install

# Настроить окружение
cp (windows - copy) .env.example .env
php artisan key:generate

# Настроить БД в .env
DB_DATABASE=car_booking
DB_USERNAME=root
DB_PASSWORD=

# Запустить миграции и тестовые данные
php artisan migrate --seed
php artisan passport:client --personal
php artisan passport:keys

# Запустить сервер
php artisan serve

# Документация API (Swagger)
http://localhost:8000/api/documentation

# Тестовые пользователи
executive@example.com / password
director@example.com / password
manager@example.com / password

# API Endpoints
POST /api/login - Авторизация
POST /api/auth/logout - Выход
GET /api/auth/me - Профиль пользователя
GET /api/available-cars - Лист доступных автомобилей
