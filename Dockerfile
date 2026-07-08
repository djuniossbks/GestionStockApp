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

# Création du script de démarrage
# On lance la migration, puis on force les permissions sur les dossiers critiques, enfin on lance Apache
RUN echo '#!/bin/bash\n\
php artisan migrate --force\n\
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache\n\
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache\n\
apache2-foreground' > /usr/local/bin/start.sh \
    && chmod +x /usr/local/bin/start.sh

EXPOSE 80

# Lancement du script
CMD ["/usr/local/bin/start.sh"]
