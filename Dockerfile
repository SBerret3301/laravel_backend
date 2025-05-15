FROM php:8.2-apache

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# إعدادات Laravel
WORKDIR /var/www/html

COPY . .

RUN docker-php-ext-install pdo pdo_mysql

# السماح بالكتابة داخل storage و bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache
