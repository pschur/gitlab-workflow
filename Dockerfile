FROM php:apache-trixie

RUN apt-get update 
RUN apt-get install -y zip unzip git curl docker.io
RUN apt install -y libzip-dev libcurl4-openssl-dev pkg-config libssl-dev

RUN docker-php-ext-install curl

RUN a2enmod rewrite

COPY . /var/www/html