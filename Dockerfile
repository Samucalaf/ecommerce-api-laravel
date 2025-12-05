FROM php:8.2-fpm

# Argumentos
ARG user=ecommerce
ARG uid=1000

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar dependências do PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev

# Instalar extensões PHP
RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip

# Instalar Redis
RUN pecl install redis && docker-php-ext-enable redis

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar usuário do sistema
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Instalar Xdebug corretamente
RUN apt-get update && apt-get install -y autoconf gcc make
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
# Configurar diretório de trabalho
WORKDIR /var/www

USER $user

EXPOSE 9000
CMD ["php-fpm"]
