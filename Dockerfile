# Utilisation de PHP 8.4 avec Apache
FROM php:8.4-apache AS production

# Installation des dépendances système
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

# Copie des fichiers
COPY . .

# Installation des dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Correction spécifique pour Render : 
# On modifie les fichiers de config pour utiliser $PORT au lieu de 80
RUN sed -i 's/Listen 80/Listen ${PORT:-8080}/g' /etc/apache2/ports.conf && \
    sed -i 's/:80/:${PORT:-8080}/g' /etc/apache2/sites-available/000-default.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exposition
EXPOSE 8080

# Commande de lancement
CMD ["apache2-foreground"]
