FROM php:apache-trixie

RUN apt-get update 
RUN apt-get install -y zip unzip git curl docker.io

RUN docker-php-ext-install curl

RUN a2enmod rewrite

COPY . /var/www/html