FROM php:8.1-apache

# Instalamos las dependencias y extenciones necesarias para el php

RUN apt-get update \
    && apt-get -y --no-install-recommends install autoconf g++ zlib1g-dev \
    && apt-get install -y \
        libpq-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libxml2-dev \
        libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        mysqli \
        pdo_mysql \
        bcmath \
        soap \
        zip \
    && pecl install xdebug-3.1.3 \
    && docker-php-ext-enable xdebug

# Instalamos composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

WORKDIR /var/www

RUN mkdir demo && mkdir demo/api

RUN chown www-data: -R * && chown www-data: -R .*

COPY ./conf/dir.conf /etc/apache2/mods-enabled/dir.conf

COPY ./conf/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2ensite 000-default.conf && \
    a2enmod rewrite