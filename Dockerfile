FROM php:8.4-apache

# Install dependensi sistem dan extension PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    && rm -rf /var/lib/apt/lists/*

# Aktifkan mod_rewrite
RUN a2enmod rewrite

# Atur Document Root Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri \
    -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

RUN sed -ri \
    -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/conf-available/*.conf

# Izinkan .htaccess Laravel
RUN printf '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n' \
    > /etc/apache2/conf-available/laravel.conf

RUN a2enconf laravel

# Direktori kerja
WORKDIR /var/www/html

# Salin proyek
COPY . .

RUN mkdir -p database && touch database/database.sqlite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install \
    --no-interaction \
    --optimize-autoloader \
    --no-dev

# Siapkan direktori Laravel
RUN mkdir -p \
    storage/logs \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache

# Atur permission
RUN chown -R www-data:www-data \
     /var/www/html/storage \
    /var/www/html/bootstrap/cache

RUN chmod -R 775 \
      /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Port Apache
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]