# Dockerfile для проекта Laravel
FROM php:7.4-fpm-alpine

# Установка расширений PHP
RUN docker-php-ext-install pdo pdo_mysql

# Установка композера
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка рабочего каталога
WORKDIR /var/www

# Копирование файлов проекта
COPY . .

# Установка зависимостей
RUN composer install

# Запуск миграций и добавление записи в таблицу admins
RUN php artisan migrate --seed

# Запуск проекта
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
