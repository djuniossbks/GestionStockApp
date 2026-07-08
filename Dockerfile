FROM php:8.4-apache

# Installation des extensions nécessaires
RUN apt-get update && apt-get install -y libpng-dev libonig-dev libxml2-dev zip unzip git \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuration Apache pour Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && a2enmod rewrite

# Copie des fichiers
WORKDIR /var/www/html
COPY . .

# Installation des dépendances
RUN composer install --no-dev --optimize-autoloader

# Fix des permissions (très important pour Render)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Exposition du port (Render utilise 10000 par défaut, mais 80 est standard pour le conteneur)
EXPOSE 80
