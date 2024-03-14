#!/usr/bin/env bash

cd /var/www/html || exit

composer install --prefer-dist

php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan l5-swagger:generate

if id "ubuntu" >/dev/null 2>&1; then
    chmod -R 777 storage
    chmod -R 777 bootstrap/cache
    chown -R ubuntu:ubuntu /var/www/html
else
    chmod -R 777 storage
    chmod -R 777 bootstrap/cache
    chown -R www-data:www-data /var/www/html
fi

php-fpm & sleep 3

service nginx start
tail -f /dev/null
