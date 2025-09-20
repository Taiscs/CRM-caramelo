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

# 🔹 Copia entrypoint se existir
# Verifica se o arquivo existe antes de copiar, evita erro de build
# Ajuste o caminho se estiver em outra pasta, ex: docker/entrypoint.sh
COPY entrypoint.sh /entrypoint.sh
RUN [ -f /entrypoint.sh ] && chmod +x /entrypoint.sh || echo "entrypoint.sh não encontrado, pulando chmod"

# Expõe porta
EXPOSE 8000

# Usa entrypoint para corrigir storage/cache antes de iniciar (apenas se existir)
ENTRYPOINT ["/entrypoint.sh"]

# Comando inicial
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=${PORT}"]

