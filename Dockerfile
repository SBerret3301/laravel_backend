FROM php:8.2-fpm

# إعداد التوقيت
RUN echo "Europe/Paris" > /etc/timezone

# تثبيت الإضافات المطلوبة
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libzip-dev \
    libonig-dev libxml2-dev libpq-dev libcurl4-openssl-dev libssl-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# مكان تشغيل التطبيق
WORKDIR /var/www

# نسخ الملفات
COPY . .

# صلاحيات Laravel
RUN chmod -R 775 storage bootstrap/cache

# تثبيت الباكجات
RUN composer install --optimize-autoloader --no-dev

# clear and cache config
RUN php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# منفذ التشغيل
EXPOSE 8000

# أمر التشغيل
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
