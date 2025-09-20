#!/bin/sh
# entrypoint.sh

# Ajusta permissões da pasta storage e cache
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache

# Executa o comando passado pelo CMD do Docker
exec "$@"
