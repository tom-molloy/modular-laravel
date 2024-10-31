# PHP base image

FROM php:8.3.3-fpm-alpine3.18 AS base
RUN set -ex \
  && apk add --update shadow icu postgresql-libs\
  && apk --no-cache --virtual .build-deps add postgresql-dev icu-dev \
  && docker-php-ext-configure intl \
  && docker-php-ext-install pdo pdo_pgsql bcmath intl \
  && docker-php-ext-enable intl \
  && usermod --uid 1000 www-data \
  && groupmod --gid 1000 www-data \
  && apk del .build-deps \
  && rm -rf /tmp/* /var/cache/apk/*

# Install JS dependencies

FROM node:18.20.3-alpine3.20 AS npm-install
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install

# Install PHP dependencies

FROM base AS composer-install
WORKDIR /var/www/html
COPY --from=composer:2.8.0 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
COPY modules modules
RUN composer install --no-autoloader

# Install PHP prod dependencies

FROM composer-install AS composer-install-prod
WORKDIR /var/www/html
RUN composer install --no-autoloader --no-dev

# Vite dev image
FROM npm-install AS vite-dev
COPY . .
CMD ["npm", "run", "dev"]

# Build JS assets

FROM node:18.20.3-alpine3.20 AS vite-build
WORKDIR /app
COPY --from=npm-install /app .
COPY vite.config.js tailwind.config.js postcss.config.js .
COPY public public
COPY resources resources
RUN npm run build
RUN rm -rf node_modules

# PHP-FPM dev image

FROM composer-install AS php-fpm-dev
WORKDIR /var/www/html
COPY . .
COPY --from=composer-install /var/www/html/vendor vendor
RUN composer dump -o
RUN composer run ide-helper
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html/storage
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]

# PHP-FPM prod image

FROM composer-install-prod AS php-fpm
WORKDIR /var/www/html
COPY public public
COPY --from=composer-install-prod /var/www/html/vendor vendor
COPY --from=vite-build /var/www/html/public/build public/build
COPY composer.json composer.lock ./
COPY artisan artisan
COPY bootstrap bootstrap
COPY database database
COPY storage storage
COPY routes routes
COPY config config
COPY resources resources
COPY app app
RUN composer dump -o
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html/storage

# Nginx image

FROM nginx:1.25.3-alpine3.18-slim AS nginx
WORKDIR /var/www/html
COPY nginx /etc/nginx
COPY --from=vite-build /app/ .