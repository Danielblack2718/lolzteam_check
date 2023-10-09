# lolzteam_check
1. docker-compose up -d
2. docker-compose exec db mysql -u root -p
3. CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON lolzteam.* TO 'user'@'%';
FLUSH PRIVILEGES;

4.\q
5. docker-compose exec backend php artisan migrate
    docker-compose exec backend php artisan db:seed
6. Настроить backend на порт 80

   Админ-панель: /admin
   Лог:пасс при сидировании
   admin:admin
   
