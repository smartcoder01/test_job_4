FROM php:8.3-fpm AS base
ENV TZ=UTC \
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8 \
  COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

RUN apt-get update \
  && apt-get -y install --no-install-recommends \
    libcurl4-openssl-dev pkg-config libssl-dev \
    locales \
    nginx \
    certbot \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libpq-dev \
    curl \
    openssl \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* \
  && locale-gen en_US.UTF-8 \
  && localedef -f UTF-8 -i en_US en_US.UTF-8 \
  && docker-php-ext-install \
    intl \
    pdo_pgsql \
    zip \
    pcntl \
    bcmath \
    exif \
  && composer config -g process-timeout 3600 \
  && composer config -g repos.packagist composer https://packagist.org

#   Redis
#RUN pecl install redis && docker-php-ext-enable redis

# NodeJs &PM2
#RUN apt-get update && \
#    curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
#    apt-get install -y nodejs
#
#RUN npm install -g laravel-echo-server pm2
#COPY ./docker/pm2.json /etc/pm2.json
# End NodeJs &PM2

WORKDIR /var/www/html
EXPOSE 80


# Deploy environment
FROM base AS deploy
COPY ./docker/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./ /var/www/html
COPY ./docker/entrypoint.sh /etc/entrypoint.sh
COPY ./.env.example /var/www/html/.env

# SSL && NGINX DOMAIN
ARG DOMAIN_NAME
ARG DOMAIN_EMAIL
ENV DOMAIN_NAME=${DOMAIN_NAME}
ENV DOMAIN_EMAIL=${DOMAIN_EMAIL}

RUN mkdir -p /var/www/certbot

COPY ./docker/ssl/fullchain.pem /etc/nginx/ssl/live/${DOMAIN_NAME}/fullchain.pem
COPY ./docker/ssl/privkey.pem /etc/nginx/ssl/live/${DOMAIN_NAME}/privkey.pem
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
RUN sed -i "s/\${DOMAIN_NAME}/${DOMAIN_NAME}/g" /etc/nginx/conf.d/default.conf
# END SSL && NGINX DOMAIN

CMD ["/bin/sh", "/etc/entrypoint.sh"]

# Local environment
FROM base AS development
COPY ./docker/nginx/nginx.local.conf /etc/nginx/sites-enabled/default
COPY ./docker/php.ini /usr/local/etc/php/conf.d/php.ini

COPY ./ /var/www/html
COPY ./docker/entrypoint.sh /etc/entrypoint.sh
COPY ./.env.example /var/www/html/.env

CMD ["/bin/sh", "/etc/entrypoint.sh"]
