#Gitlab registry имитация
FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    git \
    unzip \
    curl \
    libzip-dev \
    rabbitmq-c-dev \
    autoconf \
    g++ \
    make \
    && docker-php-ext-install zip \
    && pecl install amqp \
    && docker-php-ext-enable amqp

RUN curl -sS https://getcomposer.org | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
