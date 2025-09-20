# Usa imagem PHP com FPM
FROM php:8.2-fpm

# Instala dependências do sistema e extensões do PHP
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala o Composer (pega da imagem oficial)
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do projeto para dentro do container
COPY . .

# Instala dependências do Laravel
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Ajusta permissões (storage e cache)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Porta que o Laravel Serve vai escutar (Render define $PORT)
EXPOSE 8000

# Comando de inicialização (usando variável do Render)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=${PORT}"]
