# Dockerfile
FROM php:8.2-fpm

# إعداد التوقيت
RUN echo "Europe/Paris" > /etc/timezone

# تثبيت بعض الحزم
RUN apt-get update && apt-get install -y \
    nginx \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    libzip-dev libpq-dev libmcrypt-dev libxslt1-dev libmagickwand-dev --no-install-recommends \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl gd zip

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# نسخ ملفات المشروع
WORKDIR /var/www
COPY . .

# صلاحيات
RUN chmod -R 775 storage bootstrap/cache

# تثبيت Laravel
RUN composer install --optimize-autoloader --no-dev \
 && php artisan config:clear \
 && php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# نسخ إعدادات nginx
COPY ./nginx.conf /etc/nginx/nginx.conf

# فتح البورت 80
EXPOSE 80

# تشغيل nginx و php-fpm
CMD service nginx start && php-fpm
