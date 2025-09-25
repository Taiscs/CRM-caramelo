# Usa mirror do Render para PHP 8.2 FPM (evita 401 no Docker Hub)
FROM render-prod/docker-mirror-repository/library/php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Define diretório de trabalho
WORKDIR /var/www

# Copia arquivos do projeto
COPY . .

# Configura permissões de storage e bootstrap/cache
RUN mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Instala dependências PHP do projeto
RUN composer install --no-dev --optimize-autoloader

# Expõe porta que o Laravel vai usar
EXPOSE 8000

# Comando para rodar Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
