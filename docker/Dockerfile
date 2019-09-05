FROM php:7.3-fpm

MAINTAINER Jimmy <stefan.brankovik@gmail.com>

### NGINX
ARG NGINX_VERSION=1.14.2-2

RUN apt-get update && apt-get install -y --no-install-recommends apt-utils gnupg2 apt-transport-https

### NGINX
RUN addgroup --system nginx \
    && adduser --system --ingroup nginx --disabled-password --home /var/cache/nginx --disabled-login nginx \
    && apt-get install -y nginx=${NGINX_VERSION}
# Sites folders and link configuration
RUN unlink /etc/nginx/sites-enabled/default \
    && mkdir -p /usr/share/nginx/logs \
    && touch /usr/share/nginx/logs/error.log

# Required packages ( supervisor and composer )
RUN apt-get install -y wget supervisor dialog git unzip\
    musl-dev libpng-dev libffi-dev vim libicu-dev libxml2-dev libjpeg-dev libfreetype6-dev libpq-dev

### PHP
RUN pecl install xdebug-2.8.0beta1
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-png-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd exif intl json soap dom opcache bcmath pcntl pdo pdo_pgsql \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete

### COMPOSER
RUN EXPECTED_COMPOSER_SIGNATURE=$(wget -q -O - https://composer.github.io/installer.sig) \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '${EXPECTED_COMPOSER_SIGNATURE}') { echo 'Composer.phar Installer verified'; } else { echo 'Composer.phar Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"
ENV COMPOSER_CACHE_DIR /var/cache/nginx/.composer

### CLEANUP
RUN rm -rf /var/cache/* && apt-get purge -y musl-dev python-dev libffi-dev && apt-get autoremove -y
ADD conf/nginx/default.conf /etc/nginx/sites-enabled/default
ADD conf/nginx/nginx.conf /etc/nginx/nginx.conf
ADD conf/supervisord.conf /etc/supervisord.conf
ADD conf/php/docker-vars.ini /usr/local/etc/php/conf.d/
ADD conf/php/php-fpm.conf /usr/local/etc/php-fpm.conf
ADD conf/php/www.conf /usr/local/etc/php-fpm.d/www.conf

### Make scipt executable
ADD scripts/start.sh /entrypoint.sh

CMD ["/entrypoint.sh"]
