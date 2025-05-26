#!/bin/bash

set -e

# Laravel setup
cd /var/www/html

php artisan config:cache

until php artisan migrate --force; do
  echo "Waiting for MySQL to be ready..."
  sleep 5
done

exec php-fpm
