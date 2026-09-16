# ---------- frontend build ----------
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package.json ./
RUN npm install
COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/
RUN npm run build

# ---------- php runtime ----------
FROM php:8.4-apache

# system deps + php exts for Laravel 12 + MySQL + SQLite
RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev libsqlite3-dev \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# apache serve public/, not root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# 1. php deps first (cache layer)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# 2. full code
COPY . .
COPY --from=frontend /app/public/build ./public/build

# 3. autoload optimize + perms
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# 4. frontend already built in frontend stage.
# If single-stage wanted instead: RUN npm install && npm run build
# kept multi-stage: small final image, no node bloat.

# 5. clear stale cache at build end (user asked config:clear)
RUN php artisan config:clear || true

EXPOSE 80

# 6. runtime: key check + migrate + serve. Single CMD only.
# key:generate NOT forced each boot (would rotate keys, kill sessions).
# migrate needs live DB, so runtime not buildtime.
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
