# Usa imagem PHP com FPM
FROM php:8.2-fpm

# Instala dependências do sistema e extensões do PHP
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www

# Copia os arquivos do projeto
COPY . .

# Instala dependências do Laravel (sem dev)
RUN composer install --no-dev --optimize-autoloader

# Garante que está em produção
ENV APP_ENV=production

# Gera caches do Laravel
RUN php artisan config:clear \
    && php artisan cache:clear \
    && php artisan route:cache \
    && php artisan view:cache

# Permissões para storage e cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Define porta
EXPOSE 8000

# Comando inicial do container
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=${PORT}"]

