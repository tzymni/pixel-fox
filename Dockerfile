FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    sudo git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    libzip-dev default-mysql-client && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd sockets


COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

ARG UID
ARG GID
ARG USERNAME
ARG GROUP_NAME

RUN addgroup --gid $GID $GROUP_NAME && \
    adduser --disabled-password --gecos "" --uid $UID --gid $GID $USERNAME && \
    usermod -aG sudo $USERNAME && \
    echo "$USERNAME ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers



USER $USERNAME
