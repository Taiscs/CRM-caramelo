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

# Copia e configura entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expõe porta
EXPOSE 8000

# Usa entrypoint para garantir pastas e permissões
ENTRYPOINT ["/entrypoint.sh"]

# Comando inicial do container
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=$PORT"]




