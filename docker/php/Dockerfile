#IF u really need to run the same version as in prod use php:7.3-fpm-alpine
#but we run it our pipeline that should be enough and php 7.4 ist faster --> better
#php:7.3-fpm-alpine
FROM php:7.4-fpm-alpine

RUN \
    echo "http://dl-cdn.alpinelinux.org/alpine/v3.14/cofmmunity" >> /etc/apk/repositories \
    && echo "http://dl-cdn.alpinelinux.org/alpine/v3.14/main" >> /etc/apk/repositories \
    && apk --no-cache  update \
    && apk --no-cache  upgrade \
    && apk add --no-cache \
       zlib-dev icu-dev \
       fish bash wget git autoconf libzip-dev gcc g++ make tzdata \
       chromium chromium-chromedriver \
    && docker-php-ext-install opcache pdo_mysql zip intl

#this is pcov a faster php code coverage driver
RUN pecl install pcov && \
    docker-php-ext-enable pcov

RUN apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS \
        && pecl install apcu \
        && docker-php-ext-enable apcu \
        && pecl clear-cache \
        && apk del .build-dependencies
RUN mkdir -p /.composer && chown 1000 /.composer \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker/php/.bash_history /.bash_history
RUN chmod 777 /.bash_history \
    && export HISTFILE=/.bash_history

ENV TZ=Europe/Berlin

RUN cp /usr/share/zoneinfo/$TZ /etc/localtime

RUN adduser -D -g '' phpuser
USER phpuser

COPY ./docker/php/.bash_history /home/phpuser/.bash_history
ENV PATH="/home/phpuser/.composer/vendor/bin:${PATH}"

WORKDIR /usr/src/app

ENV SHELL /usr/bin/fish
