# ===========================
# Stage 1: Composer + dependências
# ===========================
FROM composer:2.7 AS composer-stage

# Define diretório de trabalho
WORKDIR /app

# Copia apenas os arquivos do Composer para cache de dependências
COPY composer.json composer.lock ./

# Instala dependências do Laravel (sem dev e otimizado)
RUN composer install --no-dev --optimize-autoloader

# ===========================
# Stage 2: PHP 8.2 FPM
# ===========================
FROM php:8.2-fpm

# Define diretório de trabalho
WORKDIR /var/www

# Instala extensões e dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copia as dependências instaladas no stage anterior
COPY --from=composer-stage /app/vendor ./vendor

# Copia o restante do projeto
COPY . .

# Cria storage e bootstrap/cache com permissões corretas
RUN mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expõe a porta que o Laravel Serve vai usar
EXPOSE 8000

# Comando para rodar a aplicação
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
