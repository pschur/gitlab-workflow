FROM php:apache-trixie

RUN apt-get update 
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev libzip-dev zip unzip git curl docker.io

RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-install curl

RUN a2enmod rewrite

COPY . /var/www/html