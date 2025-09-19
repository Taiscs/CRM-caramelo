# Usa uma imagem oficial do PHP com o servidor web FPM
FROM php:8.2-fpm-alpine

# Instala as dependências do sistema necessárias para o PHP
RUN apk add --no-cache \
    curl \
    mysql-client \
    git \
    libxml2-dev \
    pcre-dev \
    libzip-dev

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala as extensões PHP necessárias para o Laravel
RUN docker-php-ext-install pdo pdo_mysql opcache \
    && pecl install zip \
    && docker-php-ext-enable zip

# Define o diretório de trabalho
WORKDIR /app

# Copia os arquivos da sua aplicação para o diretório de trabalho
COPY . /app

# Roda o Composer para instalar as dependências
RUN composer install --no-dev --optimize-autoloader

# Expõe a porta 9000 para o FPM
EXPOSE 9000

# Define o comando de início do servidor
CMD ["php-fpm"]
