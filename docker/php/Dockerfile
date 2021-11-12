FROM php:8.0.1-fpm-buster

WORKDIR /var/www
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="1"

RUN apt-get update && apt-get install -y locales libmagickwand-dev libpng-dev --no-install-recommends

RUN pecl install redis xdebug imagick

RUN docker-php-ext-install pdo pdo_mysql pcntl opcache gd
RUN docker-php-ext-enable pdo pdo_mysql pcntl redis xdebug imagick

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Add UID '1000' to www-data
RUN groupmod -o -g 1000 www-data && \
    usermod -o -u 1000 -g www-data www-data

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www

USER www-data
