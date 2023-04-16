FROM ubuntu:kinetic

ARG DEBIAN_FRONTEND=noninteractive
ARG APP_DL_INSTALL_MODE=DOCKER
ARG user=ubuntu

RUN apt update
RUN apt -y upgrade
RUN apt -y -q install zip unzip
RUN apt -y -q install tzdata
RUN apt -y -q install php8.1 php8.1-pgsql
RUN apt -y -q install php8.1-intl php8.1-pgsql php8.1-pdo php8.1-xdebug

RUN useradd -U $user
USER $user

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY  ["composer.json", "."]
COPY ["composer.lock", "."]

RUN composer install --optimize-autoloader --no-interaction --profile --version --no-scripts

COPY . .

RUN composer console-install
