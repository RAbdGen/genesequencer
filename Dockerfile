FROM alpine:3.18

# Install default packages
RUN apk update \
    && apk add git unzip bash

# Install and configure PHP packages
RUN apk add php82-cli php82-pecl-xdebug php82-pecl-apcu php82-dom php82-intl php82-pdo_sqlite \
            php82-tokenizer php82-mbstring php82-opcache php82-xml php82-xmlwriter php82-openssl php82-phar \
    && ln -s /usr/bin/php82 /usr/bin/php

RUN echo "zend_extension=xdebug.so" >> /etc/php82/conf.d/50_xdebug.ini \
    && echo "xdebug.mode=coverage" >> /etc/php82/conf.d/50_xdebug.ini \
    && echo "apc.enable_cli=1" >> /etc/php82/conf.d/apcu.ini

# Install Composer
RUN /usr/bin/php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && /usr/bin/php composer-setup.php --filename=composer --install-dir=/usr/local/bin \
    && /usr/bin/php -r "unlink('composer-setup.php');"

WORKDIR /app