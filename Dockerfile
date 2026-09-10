FROM php:8.4-apache

# 2. Install dependensi sistem dan extension PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 3. Aktifkan modul mod_rewrite Apache untuk routing Laravel
RUN a2enmod rewrite

# 4. Atur Document Root Apache mengarah ke folder /public milik Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

# 5. Tentukan direktori kerja di dalam kontainer
WORKDIR /var/www/html

# 6. Salin semua file proyek dari komputer/GitHub ke dalam kontainer
COPY . .

# 7. Install Composer secara otomatis
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 8. Atur hak akses folder storage dan bootstrap/cache agar bisa ditulis oleh Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Buka port 80 untuk akses web
EXPOSE 80

# 10. Jalankan Apache
CMD ["apache2-foreground"]