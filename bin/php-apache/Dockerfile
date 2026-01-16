FROM php:7.2-apache

# Configurar repositórios para versão arquivada do Debian
RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i 's/security.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i '/stretch-updates/d' /etc/apt/sources.list

# Desabilitar site padrão
RUN a2dissite 000-default

# Atualizar repositórios e instalar dependências básicas
RUN apt-get update && apt-get install -y \
    libz-dev \
    libpq-dev \
    libmemcached-dev \
    curl \
    python3 \
    graphviz \
    gnupg \
    git \
    libzip-dev \
    zip \
    unzip \
    libpng-dev \
    supervisor \
    libsqlite3-dev \
    libsqlite3-0 \
    mariadb-client \
    && rm -rf /var/lib/apt/lists/*

# Habilitar módulos do Apache
RUN a2enmod expires headers rewrite ssl proxy proxy_http

# Configurar AllowOverride no Apache
RUN sed -e '/<Directory \/var\/www\/>/,/<\/Directory>/s/AllowOverride None/AllowOverride All/' -i /etc/apache2/apache2.conf

# Copiar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar e instalar extensões PHP
RUN docker-php-ext-configure zip --with-libzip && \
    docker-php-ext-install -j$(nproc) pdo_mysql gd zip mysqli

# Configurar timezone
ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Instalar extensão timezonedb
RUN docker-php-source extract && \
    pecl bundle -d /usr/src/php/ext timezonedb && \
    docker-php-ext-configure timezonedb && \
    docker-php-ext-install -j$(nproc) timezonedb && \
    docker-php-source delete

# Comando padrão
CMD ["apache2-foreground"]