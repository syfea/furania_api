FROM php:7.3-alpine

RUN docker-php-ext-install pdo pdo_mysql

#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apk add --update nodejs npm

COPY . /

RUN apk add --no-cache bash

CMD php -S 0.0.0.0:80 var/www/public/index.php