FROM php:8.1-apache

# Atualiza o sistema e instala pacotes necessários
RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y nano libpq-dev libmemcached-dev zlib1g-dev libpng-dev libwebp-dev libjpeg62-turbo-dev libxpm-dev libfreetype6-dev libzip-dev unzip git tzdata libxml2-dev libapache2-mod-evasive gettext libzstd-dev wget curl gnupg

# Instala extensões do PHP
RUN docker-php-ext-install pdo pdo_pgsql pgsql gd zip exif soap gettext mysqli pdo_mysql bcmath

# Configura extensões adicionais
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Instala extensões PECL
RUN pecl install memcached xdebug igbinary redis

# Habilita extensões
RUN docker-php-ext-enable memcached xdebug igbinary exif

# Configura o módulo pgsql
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

# Habilita módulos do Apache
RUN a2enmod rewrite headers ssl proxy proxy_http env

# Cria diretório para sessões PHP
RUN mkdir -p /var/php-session \
    && chmod -Rf 777 /var/php-session

# Grupo para gravar em pastas do host
RUN addgroup --gid 1024 docker-apache || true \
    && usermod -a -G docker-apache www-data || true

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Configura o fuso horário
ENV TZ 'America/Sao_Paulo'
RUN echo $TZ > /etc/timezone \
    && rm /etc/localtime \
    && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && dpkg-reconfigure -f noninteractive tzdata

# Apache como reverse proxy
RUN a2enmod proxy || true \
    && a2enmod proxy_http || true \
    && service apache2 restart || true

COPY ./sites-available /etc/apache2/sites-available

WORKDIR /etc/apache2/sites-available

RUN a2ensite 000-default.conf

WORKDIR /var/www/html