FROM php:8.1-apache

RUN apt-get update
RUN apt-get install -y --no-install-recommends locales apt-utils git libicu-dev g++ libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev libpq-dev unzip

RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen &&  echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen
RUN  locale-gen
RUN curl -sS https://getcomposer.org/installer | php --
RUN mv composer.phar /usr/local/bin/composer 
RUN  docker-php-ext-install pdo pdo_mysql pdo_pgsql opcache intl zip calendar dom mbstring gd xsl 
RUN pecl install apcu && docker-php-ext-enable apcu
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin
RUN docker-php-ext-configure intl 


WORKDIR /var/www/html/
