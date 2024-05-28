FROM php:8.1-apache

# Run apt update and install some dependancies needed for docker-php-ext
RUN apt-get update
RUN apt-get install -y curl postgresql postgresql-client libsodium-dev apt-utils sendmail mariadb-client \
    pngquant libpq-dev unzip zip libpng-dev libgmp-dev libmcrypt-dev git curl libicu-dev libxml2-dev  \
    libssl-dev sqlite3 build-essential \
                           libjpeg62-turbo-dev \
                           libfreetype6-dev \
                           locales \
                           jpegoptim optipng pngquant gifsicle \
                           lua-zlib-dev \
                           libmemcached-dev \
                            locales && \
                                echo "ru_RU.UTF-8 UTF-8" > /etc/locale.gen && \
                                locale-gen ru_RU.UTF-8 && \
                                /usr/sbin/update-locale LANG=ru_RU.UTF-8

# Install PHP extensions
RUN docker-php-ext-install sockets bcmath sodium gmp exif mysqli gd intl xml pdo pdo_mysql pdo_pgsql pgsql dom session opcache

# Update web root to public
# See: https://hub.docker.com/_/php#changing-documentroot-or-other-apache-configuration
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# xdebug
RUN pecl install xdebug; \
    docker-php-ext-enable xdebug; \
    echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini;

# Enable mod_rewrite
RUN a2enmod rewrite

# Права пользователя от которого запускаем docker
USER 1000:1000
