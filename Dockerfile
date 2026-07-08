# Utilisation de PHP 8.4 avec Apache
FROM php:8.4-apache AS production

# Installation des dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définition du répertoire de travail
WORKDIR /var/www/html

# Copie des fichiers du projet
COPY . .

# Installation des dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# --- CONFIGURATION APACHE ---
# On configure explicitement le port et le DocumentRoot
RUN echo 'Listen 8080\n\
<VirtualHost *:8080>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Modification du port d'écoute global
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf

# Activation du module rewrite
RUN a2enmod rewrite

# --- PERMISSIONS ---
# Attribution des droits au groupe Apache et permissions totales pour le cache/storage
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Exposition du port
EXPOSE 8080

# Commande de lancement
CMD ["apache2-foreground"]
