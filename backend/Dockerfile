# Базовый образ
FROM php:8.1-apache

# Установите рабочий каталог
WORKDIR /var/www/html

# Установите расширения PHP и MySQL клиента
RUN apt-get update && \
    apt-get install -y \
    libpq-dev \
    libonig-dev \
    libicu-dev \
    zip \
    unzip \
    git \
    curl \
    default-mysql-client && \
    docker-php-ext-install pdo_pgsql mbstring intl pdo_mysql

# Установите Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируйте файлы проекта в образ
COPY . .

# Установите зависимости
RUN composer install --prefer-dist --no-progress --no-suggest --optimize-autoloader --no-dev

# Выполните миграции и добавьте пользователя в базу данных
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Копирование скрипта start.sh в корень файловой системы контейнера
COPY start.sh /

# Даем права на выполнение скрипту
RUN chmod +x /start.sh

# Команда для запуска скрипта start.sh
CMD ["/start.sh"]

