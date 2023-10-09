#!/bin/bash
# Даем права на выполнение скрипта
./wait-for-db.sh db:3306 --timeout=30

# Выполняем миграции и сидеры
php artisan migrate --force
php artisan db:seed --force

# Запускаем Apache
apache2-foreground
