# Use PHP with FPM
FROM php:8.2-fpm

# Set timezone
RUN echo "Europe/Paris" > /etc/timezone

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libzip-dev \
    libonig-dev libxml2-dev libpq-dev libcurl4-openssl-dev libssl-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Give permissions to storage and cache
RUN chmod -R 775 storage bootstrap/cache

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Laravel: clear and cache config
RUN php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Open port
EXPOSE 8080

# Run Laravel with PHP built-in server on port 8080
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
