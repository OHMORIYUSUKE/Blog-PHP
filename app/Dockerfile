FROM php:7.4-apache

COPY php.ini /usr/local/etc/php/

RUN apt-get update \
  && docker-php-ext-install pdo_mysql

RUN a2enmod rewrite \
  && service apache2 restart

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd
