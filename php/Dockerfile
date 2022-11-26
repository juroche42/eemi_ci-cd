FROM php:8.1.0-fpm

RUN apt-get update \
	&& apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN echo 'max_execution_time = 300' >> /usr/local/etc/php/conf.d/docker-php-maxexectime.ini;
RUN echo 'memory_limit = 256M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;

RUN pecl install apcu \
	&& docker-php-ext-install intl opcache pdo pdo_mysql zip \
	&& docker-php-ext-enable apcu opcache \
	&& docker-php-ext-configure zip

WORKDIR /var/www/symfony_docker