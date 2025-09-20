# ----------------------------
# STAGE 1: Build com Composer
# ----------------------------
FROM php:8.2-cli AS build

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /app

# Copia apenas arquivos necessários para instalar dependências
COPY composer.json composer.lock ./

# Instala dependências sem dev para produção
RUN composer install --no-dev --optimize-autoloader --no-scripts

# ----------------------------
# STAGE 2: Produção
# ----------------------------
FROM php:8.2-fpm

# Instala extensões do PHP necessárias em runtime
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia código-fonte do Laravel
COPY . .

# Copia vendor do stage de build
COPY --from=build /app/vendor ./vendor

# Ajusta permissões de storage e cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Porta que o Laravel Serve vai escutar (Render define $PORT)
EXPOSE 8000




# Comando de inicialização
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
