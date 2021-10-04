FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    curl \
    wget \
    git \
    libmcrypt-dev libonig-dev libpq-dev libzip-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    && docker-php-ext-enable mysqli pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www

EXPOSE 9000