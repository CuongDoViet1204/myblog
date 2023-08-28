FROM php:7.4-fpm-alpine
RUN docker-php-ext-install pdo_mysql

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME / composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer