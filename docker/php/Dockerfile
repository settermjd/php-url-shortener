ARG FPM_VERSION=alpine3.16
ARG PHP_VERSION=8.1

FROM php:${PHP_VERSION}-fpm-${FPM_VERSION} as base

RUN apk --update-cache add git libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && rm -rf /var/cache/apk/*

# Set the appropriate level of error reporting.
COPY ./docker/php/config/ini/conf.d/error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini
