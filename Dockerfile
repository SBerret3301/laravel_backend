# المرحلة الأولى: إعداد Composer
FROM composer:2 AS vendor

WORKDIR /app

# انسخ ملفات Laravel
COPY . .

# ضروري تكون .env موجودة باش ينجح install
RUN cp .env.example .env \
    && composer install --no-dev --prefer-dist --optimize-autoloader

# المرحلة الثانية: إعداد PHP مع FPM
FROM php:8.2-fpm

# تثبيت مكتبات PHP المطلوبة
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpng-dev libonig-dev libxml2-dev libpq-dev

RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# انسخ Composer من المرحلة السابقة
COPY --from=vendor /app /var/www

WORKDIR /var/www

# إعداد صلاحيات Laravel
RUN chmod -R 775 storage bootstrap/cache

# فتح البورت 8000
EXPOSE 8000

# الأمر النهائي لتشغيل Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
