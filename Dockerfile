FROM php:8.3-apache

# Instala las extensiones necesarias de PHP para Laravel
RUN apt-get update && apt-get install -y \
    zip git npm \
    libpng-dev libjpeg-dev libzip-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mysqli

RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar gestor de paquetes composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar las dependencias del proyecto Laravel
RUN composer install

# Habilitar mod_rewrite de Apache para Laravel
RUN a2enmod rewrite

# Cambiar permisos para el VirtualHost
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html

# Cambiar configuracion
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Pasar proyecto completo al VirtualHost de cada uno
RUN mkdir -p /var/www/html/
COPY . /var/www/html

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Instalar las dependencias con npm
RUN npm install && npm run build

# Cambiar al usuario www-data
USER www-data

# Exponer el puerto 80
EXPOSE 80