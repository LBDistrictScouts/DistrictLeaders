FROM ubuntu:kinetic

ARG DEBIAN_FRONTEND=noninteractive
ARG APP_DL_INSTALL_MODE=DOCKER
ARG user=ubuntu

RUN apt update
RUN apt -y upgrade
RUN apt -y -q install zip unzip
RUN apt -y -q install tzdata
RUN apt -y -q install php8.1 php8.1-pgsql
RUN apt -y -q install php8.1-intl php8.1-pgsql php8.1-pdo php8.1-xdebug php8.1-dom php8.1-simplexml

RUN useradd -U $user
WORKDIR /var/www/html
RUN chown -R $user:$group /var/www/html
USER $user

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY  ["composer.json", "."]
COPY ["composer.lock", "."]
RUN composer --version
RUN composer install --optimize-autoloader --no-interaction --profile --no-scripts --prefer-dist

COPY . .

RUN composer console-install
