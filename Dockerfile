# Dockerfile
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev \
    libxml2-dev libzip-dev libpq-dev libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring exif pcntl zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Working dir
WORKDIR /var/www

# Copy project
COPY . .

# Permissions
RUN chmod -R 775 storage bootstrap/cache

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Laravel optimize
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Open port
EXPOSE 8080

# Serve app
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
