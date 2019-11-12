FROM composer:latest AS composer
FROM php:7.3-fpm-alpine3.9

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache $PHPIZE_DEPS \
        pcre2 \
        pcre2-dev \
        mysql-dev \
    && docker-php-source extract \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql \
    #PECL installs
    && pecl install xdebug \
    #PECL installs enable
    && docker-php-ext-enable xdebug \
    #REMOVE unneeded
    && docker-php-source delete \
    && apk del --purge $PHPIZE_DEPS

WORKDIR /opt/app