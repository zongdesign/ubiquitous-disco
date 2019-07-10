FROM composer:latest AS composer_data
ARG composer_additional_flags=--no-dev
WORKDIR /app
COPY composer.lock composer.json /app/
RUN composer install --ignore-platform-reqs ${composer_additional_flags} --no-interaction --no-scripts --prefer-dist --optimize-autoloader

FROM php:7.2-fpm
RUN apt-get update \
    && apt-get install -y \
        librabbitmq-dev \
        libssh-dev \
        zip \
        unzip \
        bzip2 \
        git \
        cron \
        netcat-openbsd \
    && apt-get clean -y \
    && docker-php-ext-install \
        bcmath \
        sockets \
        pdo \
        pdo_mysql \
    && pecl install amqp redis xdebug \
    && docker-php-ext-enable amqp redis xdebug

RUN apt-get update && apt-get install -y libc-client-dev libkrb5-dev
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

# Install XDebug
RUN if [ "$ENV" = "dev" ]; \
        then apt-get update && pecl install xdebug && docker-php-ext-enable xdebug; \
    fi

# Configure XDebug
RUN if [ "$ENV" = "dev" ]; \
        then { \
            echo "xdebug.profiler_enable=0"; \
            echo "xdebug.remote_autostart=0"; \
            echo "xdebug.remote_enable=1"; \
            echo "xdebug.max_nesting_level=500"; \
            echo "xdebug.remote_host=192.168.1.10"; \
            echo "xdebug.remote_port=9001"; \
        } | tee -a /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        fi


COPY ./docker/php-fpm/crontab /etc/cron.d/connect
RUN touch /var/log/cron.log
RUN chmod 0644 /etc/cron.d/connect
RUN crontab /etc/cron.d/connect

WORKDIR /var/www
COPY --chown=www-data:www-data --from=composer_data /app /var/www
COPY . /var/www
COPY ./docker/php-fpm/files /startup
RUN chmod +x -R /startup
ENTRYPOINT ["/startup/entrypoint.sh"]

EXPOSE 9000