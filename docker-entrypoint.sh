#!/bin/bash

set -e

# Załaduj crona
if [ -f /crontab.txt ]; then
  crontab /crontab.txt
fi

# Uruchom cron
service cron start

# Laravel setup
cd /var/www/html

php artisan config:cache

until php artisan migrate --force; do
  echo "Waiting for MySQL to be ready..."
  sleep 5
done

# Start php-fpm na pierwszym planie
exec php-fpm
