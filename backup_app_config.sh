#!/bin/bash

# Konfigurácia
BACKUP_DIR="config-backup"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_NAME="asistanto_config_backup_${TIMESTAMP}"

# Funkcia na logovanie
log_message() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

# Funkcia na vytvorenie adresárovej štruktúry
create_backup_structure() {
    local backup_path="$BACKUP_DIR/$BACKUP_NAME"
    mkdir -p "$backup_path"/{backend,docker,frontend-admin,frontend-customer,frontend-employee}
    echo "$backup_path"
}

# Funkcia na kopírovanie súboru ak existuje
copy_if_exists() {
    local src="$1"
    local dest="$2"
    if [ -f "$src" ]; then
        mkdir -p "$(dirname "$dest")"
        cp "$src" "$dest"
        log_message "Backed up: $src"
    fi
}

# Funkcia na kopírovanie adresára ak existuje
copy_dir_if_exists() {
    local src="$1"
    local dest="$2"
    if [ -d "$src" ]; then
        mkdir -p "$(dirname "$dest")"
        cp -r "$src" "$dest"
        log_message "Backed up directory: $src"
    fi
}

# Začiatok zálohovania
log_message "Starting configuration backup..."

# Vytvorenie zálohovacej štruktúry
BACKUP_PATH=$(create_backup_structure)
log_message "Created backup directory: $BACKUP_PATH"

# Zálohovanie root konfiguračných súborov
copy_if_exists "docker-compose.yml" "$BACKUP_PATH/docker-compose.yml"
copy_if_exists ".env" "$BACKUP_PATH/.env"
copy_if_exists ".gitignore" "$BACKUP_PATH/.gitignore"

# Zálohovanie Docker konfigurácií
DOCKER_CONFIG_PATH="$BACKUP_PATH/docker"
copy_if_exists "docker/Dockerfile-nginx" "$DOCKER_CONFIG_PATH/Dockerfile-nginx"
copy_if_exists "docker/Dockerfile-node-admin" "$DOCKER_CONFIG_PATH/Dockerfile-node-admin"
copy_if_exists "docker/Dockerfile-node-customer" "$DOCKER_CONFIG_PATH/Dockerfile-node-customer"
copy_if_exists "docker/Dockerfile-node-employee" "$DOCKER_CONFIG_PATH/Dockerfile-node-employee"
copy_if_exists "docker/Dockerfile-php-fpm" "$DOCKER_CONFIG_PATH/Dockerfile-php-fpm"
copy_if_exists "docker/nginx.conf" "$DOCKER_CONFIG_PATH/nginx.conf"
copy_dir_if_exists "docker/nginx" "$DOCKER_CONFIG_PATH/nginx"
copy_dir_if_exists "docker/php" "$DOCKER_CONFIG_PATH/php"

# Zálohovanie Backend konfigurácií
BACKEND_CONFIG_PATH="$BACKUP_PATH/backend"
copy_if_exists "backend/.env" "$BACKEND_CONFIG_PATH/.env"
copy_if_exists "backend/.env.example" "$BACKEND_CONFIG_PATH/.env.example"
copy_if_exists "backend/composer.json" "$BACKEND_CONFIG_PATH/composer.json"
copy_if_exists "backend/package.json" "$BACKEND_CONFIG_PATH/package.json"
copy_dir_if_exists "backend/config" "$BACKEND_CONFIG_PATH/config"
copy_dir_if_exists "backend/database/migrations" "$BACKEND_CONFIG_PATH/database/migrations"
copy_dir_if_exists "backend/database/seeders" "$BACKEND_CONFIG_PATH/database/seeders"
copy_dir_if_exists "backend/routes" "$BACKEND_CONFIG_PATH/routes"

# Zálohovanie Frontend konfigurácií
# Admin
FRONTEND_ADMIN_PATH="$BACKUP_PATH/frontend-admin"
copy_if_exists "frontend-admin/.env" "$FRONTEND_ADMIN_PATH/.env"
copy_if_exists "frontend-admin/package.json" "$FRONTEND_ADMIN_PATH/package.json"
copy_if_exists "frontend-admin/vite.config.ts" "$FRONTEND_ADMIN_PATH/vite.config.ts"
copy_if_exists "frontend-admin/tsconfig.json" "$FRONTEND_ADMIN_PATH/tsconfig.json"
copy_if_exists "frontend-admin/tailwind.config.js" "$FRONTEND_ADMIN_PATH/tailwind.config.js"

# Customer
FRONTEND_CUSTOMER_PATH="$BACKUP_PATH/frontend-customer"
copy_if_exists "frontend-customer/.env" "$FRONTEND_CUSTOMER_PATH/.env"
copy_if_exists "frontend-customer/package.json" "$FRONTEND_CUSTOMER_PATH/package.json"
copy_if_exists "frontend-customer/vite.config.ts" "$FRONTEND_CUSTOMER_PATH/vite.config.ts"
copy_if_exists "frontend-customer/tsconfig.json" "$FRONTEND_CUSTOMER_PATH/tsconfig.json"
copy_if_exists "frontend-customer/tailwind.config.js" "$FRONTEND_CUSTOMER_PATH/tailwind.config.js"

# Employee
FRONTEND_EMPLOYEE_PATH="$BACKUP_PATH/frontend-employee"
copy_if_exists "frontend-employee/.env" "$FRONTEND_EMPLOYEE_PATH/.env"
copy_if_exists "frontend-employee/package.json" "$FRONTEND_EMPLOYEE_PATH/package.json"
copy_if_exists "frontend-employee/vite.config.ts" "$FRONTEND_EMPLOYEE_PATH/vite.config.ts"
copy_if_exists "frontend-employee/tsconfig.json" "$FRONTEND_EMPLOYEE_PATH/tsconfig.json"
copy_if_exists "frontend-employee/tailwind.config.js" "$FRONTEND_EMPLOYEE_PATH/tailwind.config.js"

# Vytvorenie archívu
cd "$BACKUP_DIR"
tar -czf "${BACKUP_NAME}.tar.gz" "$BACKUP_NAME"
cd ..

# Vyčistenie
rm -rf "$BACKUP_DIR/$BACKUP_NAME"

# Vytvorenie restore skriptu
cat > "$BACKUP_DIR/restore.sh" << 'EOL'
#!/bin/bash

if [ -z "$1" ]; then
    echo "Usage: ./restore.sh <backup_archive.tar.gz>"
    exit 1
fi

BACKUP_ARCHIVE=$1

# Rozbalenie archívu
tar -xzf "$BACKUP_ARCHIVE"
BACKUP_DIR=$(basename "$BACKUP_ARCHIVE" .tar.gz)

# Obnovenie konfigurácií
cp -r "$BACKUP_DIR"/* ./
rm -rf "$BACKUP_DIR"

echo "Configuration restored successfully!"
EOL

chmod +x "$BACKUP_DIR/restore.sh"

log_message "Backup completed successfully!"
log_message "Backup archive created: $BACKUP_DIR/${BACKUP_NAME}.tar.gz"
log_message "To restore configurations, use: ./restore.sh ${BACKUP_NAME}.tar.gz"