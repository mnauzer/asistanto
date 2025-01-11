#!/bin/bash

# Funkcia na zálohovanie súboru
backup_file() {
    local file=$1
    if [ -f "backend/$file" ]; then
        echo "Backing up $file..."
        cp "backend/$file" "backend/$file.backup"
    fi
}

# Funkcia na výpis s časovou značkou
log_message() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

# Kontrola existencie adresára backend
if [ ! -d "backend" ]; then
    log_message "Backend directory doesn't exist. Nothing to clean."
    exit 0
fi

# Zálohovanie dôležitých súborov
log_message "Creating backups of important files..."
backup_file ".env"
backup_file ".env.example"
backup_file "composer.json"
backup_file "composer.lock"
backup_file "package.json"
backup_file "package-lock.json"

# Zálohovanie custom konfigurácií
if [ -d "backend/config" ]; then
    log_message "Backing up config directory..."
    cp -r backend/config backend/config.backup
fi

# Zálohovanie migrations
if [ -d "backend/database/migrations" ]; then
    log_message "Backing up migrations..."
    cp -r backend/database/migrations backend/migrations.backup
fi

# Zálohovanie .git ak existuje
if [ -d "backend/.git" ]; then
    log_message "Backing up .git directory..."
    mv backend/.git backend.git.tmp
fi

# Vymazanie vendor adresára
if [ -d "backend/vendor" ]; then
    log_message "Removing vendor directory..."
    rm -rf backend/vendor
fi

# Vymazanie node_modules
if [ -d "backend/node_modules" ]; then
    log_message "Removing node_modules..."
    rm -rf backend/node_modules
fi

# Vymazanie composer.lock
if [ -f "backend/composer.lock" ]; then
    log_message "Removing composer.lock..."
    rm backend/composer.lock
fi

# Vymazanie package-lock.json
if [ -f "backend/package-lock.json" ]; then
    log_message "Removing package-lock.json..."
    rm backend/package-lock.json
fi

# Vymazanie cache a generovaných súborov
log_message "Cleaning Laravel cache and generated files..."
rm -rf backend/bootstrap/cache/*
rm -rf backend/storage/framework/cache/*
rm -rf backend/storage/framework/sessions/*
rm -rf backend/storage/framework/views/*
rm -rf backend/storage/logs/*
rm -rf backend/storage/app/public/*

# Vymazanie IDE helper súborov
rm -f backend/.phpstorm.meta.php
rm -f backend/_ide_helper.php
rm -f backend/_ide_helper_models.php

# Vytvorenie potrebných adresárov a nastavenie práv
log_message "Recreating necessary directories..."
mkdir -p backend/bootstrap/cache
mkdir -p backend/storage/framework/cache
mkdir -p backend/storage/framework/sessions
mkdir -p backend/storage/framework/views
mkdir -p backend/storage/logs
mkdir -p backend/storage/app/public

# Obnovenie práv
log_message "Setting correct permissions..."
chmod -R 775 backend/storage
chmod -R 775 backend/bootstrap/cache

# Obnovenie .git ak existoval
if [ -d "backend.git.tmp" ]; then
    log_message "Restoring .git directory..."
    mv backend.git.tmp backend/.git
fi

log_message "Cleanup completed successfully!"
log_message "Backups created with .backup extension"
log_message ""
log_message "To restore any backup, use:"
log_message "cp backend/[file].backup backend/[file]"
log_message ""
log_message "For example:"
log_message "cp backend/.env.backup backend/.env"