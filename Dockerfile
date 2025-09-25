# Usa PHP 8.2 FPM oficial
FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl unzip zip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# Instala Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Define diretório de trabalho
WORKDIR /var/www

# Copia arquivos do projeto
COPY . .

# Instala dependências PHP via Composer
RUN composer install --no-dev --optimize-autoloader

# Garante permissões corretas para storage e bootstrap/cache
RUN mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expõe porta para Artisan
EXPOSE 8000

# Comando para rodar aplicação
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
