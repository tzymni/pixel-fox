FROM php:8.2-apache

# Instalacja rozszerzeń PHP potrzebnych przez Laravel
RUN apt-get update && apt-get install -y \
    zip unzip git curl libonig-dev libxml2-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# Włączenie mod_rewrite Apache
RUN a2enmod rewrite

# Ustawienia DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Kopiowanie plików projektu Laravel do katalogu public w kontenerze
COPY . /var/www/html/

# Ustawienie uprawnień dla katalogów i plików
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Uruchomienie serwera
CMD ["apache2-foreground"]
