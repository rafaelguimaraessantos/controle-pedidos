FROM php:7.4-apache

# Instala extensões necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    docker-php-ext-enable mysqli

# Ativa o mod_rewrite do Apache
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Permite .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copia os arquivos do projeto (será sobrescrito pelo volume do compose)
COPY . /var/www/html

# Instalar dependências do Composer (se composer.json existir)
RUN if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader; fi

# Definir permissões
RUN chown -R www-data:www-data /var/www/html 