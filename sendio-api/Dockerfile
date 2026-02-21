FROM php:8.4-fpm-bookworm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libssl-dev \
    unzip \
    curl \
    git \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_pgsql zip \
    && pecl install redis mongodb-2.1.0 \
    && docker-php-ext-enable redis mongodb

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .

RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8000"]
