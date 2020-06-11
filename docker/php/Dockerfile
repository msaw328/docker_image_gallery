FROM php:fpm

RUN apt update && \
    apt install -y libpq-dev && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo pgsql pdo_pgsql
