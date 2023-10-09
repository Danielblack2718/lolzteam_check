# Базовый образ
FROM php:8.1-apache

# Установите рабочий каталог
WORKDIR /var/www/html

# Установите расширения PHP
RUN apt-get update && \
    apt-get install -y \
    libpq-dev \
    libonig-dev \
    libicu-dev \
    zip \
    unzip \
    git \
    curl && \
    docker-php-ext-install pdo_pgsql mbstring intl pdo_mysql

# Установите Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируйте файлы проекта в образ
COPY . .

# Установите зависимости
RUN composer install --prefer-dist --no-progress --no-suggest --optimize-autoloader --no-dev
RUN sleep 10
# Выполните миграции и добавьте пользователя в базу данных


# Запустите Apache
CMD ["apache2-foreground"]
