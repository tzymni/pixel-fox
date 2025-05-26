FROM php:8.2-fpm

# Install required system dependencies: PHP extensions, Python, tools
RUN apt-get update && apt-get install -y \
    python3 python3-venv python3-pip sudo git curl zip unzip \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    libzip-dev default-mysql-client && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd sockets

# Install Composer from the official Composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Create application user with specified UID and GID
ARG UID
ARG GID
ARG USERNAME
ARG GROUP_NAME

RUN addgroup --gid $GID $GROUP_NAME && \
    adduser --disabled-password --gecos "" --uid $UID --gid $GID $USERNAME && \
    usermod -aG sudo $USERNAME && \
    echo "$USERNAME ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Create Python virtual environment and install Pyxelate inside it
RUN python3 -m venv /opt/venv && \
    /opt/venv/bin/pip install --upgrade pip && \
    /opt/venv/bin/pip install git+https://github.com/sedthh/pyxelate.git

# Add the virtual environment's bin directory to the system PATH
ENV PATH="/opt/venv/bin:$PATH"

# Set entrypoint script
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

# Use the non-root application user
USER $USERNAME
