# fetch the RoadRunner image, image page: <https://hub.docker.com/r/spiralscout/roadrunner>
FROM spiralscout/roadrunner:2023.2 as roadrunner

# fetch the Composer image, image page: <https://hub.docker.com/_/composer>
FROM composer:2 as composer

# build application runtime, image page: <https://hub.docker.com/_/php>
FROM php:8.2-cli-alpine as php_upstream


# persistent / runtime deps
RUN apk add --no-cache \
    acl \
    fcgi \
    file \
    gettext \
    git \
    ;

# install php extensions, image page: <https://hub.docker.com/r/mlocati/php-extension-installer>
# php extensions installer: https://github.com/mlocati/docker-php-extension-installer
COPY --from=mlocati/php-extension-installer:2 --link /usr/bin/install-php-extensions /usr/local/bin/

RUN set -eux; \
    install-php-extensions \
    apcu \
    intl \
    opcache \
    zip \
    sockets \
    pdo \
    pdo_pgsql \
    ;

# install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# install roadrunner
COPY --from=roadrunner /usr/bin/rr /usr/bin/rr

WORKDIR /app

# php ini settings
COPY docker/php/php.ini /usr/local/etc/php/

CMD ["sleep", "infinity"]
