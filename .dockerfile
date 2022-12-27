FROM php:8.2-alpine3.16 as base

ARG user=app-user
ARG uid=969

RUN apk update

RUN apk add zip unzip postgresql14-client icu-dev libpq-dev php81-pdo_pgsql php81-pgsql

RUN docker-php-ext-configure intl
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install intl pgsql pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN adduser -S -G www-data -u $uid -h /home/$user $user
RUN mkdir -p /home/$user/.composer \
    && chown -R $user:www-data /home/$user

USER $user

WORKDIR /var/www/html

COPY composer.json .
COPY composer.lock .

RUN composer install --optimize-autoloader --no-scripts --no-interaction --profile --version

COPY . .

USER root
RUN chown -R $user:www-data /var/www/html \
    && chmod -R 777 /var/www/html
USER $user

RUN mv ./config/Environment/app_parameters.docker.yml ./config/Environment/app_parameters.yml
RUN composer console-install
#RUN composer symlink

FROM base as webserver

#RUN composer migrate
#RUN composer install-base

EXPOSE 80:6001
CMD bin/cake server

FROM base as test
CMD composer test

#FROM Base as Worker
#CMD bin/cake.php queue runworker
