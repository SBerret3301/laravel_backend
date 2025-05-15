FROM php:8.2-fpm

# إعداد التوقيت
RUN echo "Europe/Paris" > /etc/timezone

# تثبيت المتطلبات
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    libpq-dev libjpeg-dev libfreetype6-dev libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl zip gd

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# إعداد المجلد الرئيسي
WORKDIR /var/www

# نسخ ملفات المشروع
COPY . .

# إعداد صلاحيات Laravel
RUN chmod -R 775 storage bootstrap/cache

# تثبيت المكتبات
RUN composer install --optimize-autoloader --no-dev

# تفعيل الأوامر الأساسية
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear

# تحديد البورت
EXPOSE 9000

# تشغيل php-fpm
CMD ["php-fpm"]
