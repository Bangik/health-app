# php
FROM php:8.2-fpm-alpine

ARG user=www-data
ARG uid=1000

RUN apk update && apk add --no-cache libpng-dev libzip-dev zlib-dev
RUN docker-php-ext-install pdo pdo_mysql gd zip bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

EXPOSE 9000

CMD ["php-fpm"]