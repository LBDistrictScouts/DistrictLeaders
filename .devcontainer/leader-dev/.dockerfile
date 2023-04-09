FROM ubuntu:kinetic

RUN apt update

RUN apt install bash zip unzip postgresql14-client icu-dev libpq-dev php81-pdo_pgsql php81-pgsql

RUN docker-php-ext-configure intl
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install intl pgsql pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY composer.json .
COPY composer.lock .

RUN composer install --optimize-autoloader --no-interaction --profile --version

COPY . .

RUN mv ./config/Environment/app_parameters.docker.yml ./config/Environment/app_parameters.yml
RUN composer console-install

