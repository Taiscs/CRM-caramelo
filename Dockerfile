# Usa imagem oficial do Composer com PHP 8.2
FROM composer:2.7-php8.2

# Define diretório de trabalho
WORKDIR /var/www

# Copia arquivos do projeto
COPY . .

# Instala dependências do sistema necessárias
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# Instala dependências PHP via Composer
RUN composer install --no-dev --optimize-autoloader

# Garante que storage e bootstrap/cache existam e tenham permissões corretas
RUN mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expõe a porta que o Artisan serve vai usar
EXPOSE 8000

# Comando para rodar a aplicação
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
