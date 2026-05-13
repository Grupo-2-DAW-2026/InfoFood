FROM php:8.2-apache

# 1. Dependencias
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev \
    zip unzip git curl
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 2. CONFIGURACIÓN DE APACHE (FORZADA)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Ajustamos el VirtualHost para que apunte a /public y acepte Override
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Esta línea es la clave: permite que Laravel tome el control total
RUN printf "<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

RUN a2enmod rewrite

# 3. Copiar código
WORKDIR /var/www/html
COPY el-pozo-webapp/ .

# 4. Composer y Permisos
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html/storage

# 5. Inicio
CMD php artisan migrate --force && apache2-foreground
