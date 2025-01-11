#!/bin/bash

# Funkcia na kontrolu chýb
check_error() {
    if [ $? -ne 0 ]; then
        echo "Error: $1"
        exit 1
    fi
}

# Kontrola existencie adresára backend
if [ -d "backend" ]; then
    # Záloha .env ak existuje
    if [ -f "backend/.env" ]; then
        cp backend/.env backend/.env.backup
        echo "Backed up existing .env file to .env.backup"
    fi

    # Záloha .git ak existuje
    if [ -d "backend/.git" ]; then
        mv backend/.git backend.git.tmp
    fi

    # Vymazanie backend adresára
    rm -rf backend
    echo "Removed existing backend directory"
fi

# Vytvorenie nového Laravel projektu
echo "Creating new Laravel 11 project..."
composer create-project laravel/laravel backend
check_error "Failed to create Laravel project"

cd backend

# Inštalácia dodatočných závislostí
echo "Installing additional dependencies..."
composer require laravel/sanctum
check_error "Failed to install Laravel Sanctum"

composer require spatie/laravel-permission
check_error "Failed to install Spatie Permissions"

composer require spatie/laravel-backup
check_error "Failed to install Spatie Backup"

composer require spatie/laravel-activitylog
check_error "Failed to install Spatie Activitylog"

composer require barryvdh/laravel-dompdf
check_error "Failed to install DomPDF"

# Inštalácia dev závislostí
echo "Installing dev dependencies..."
composer require --dev barryvdh/laravel-ide-helper
check_error "Failed to install IDE Helper"

composer require --dev laravel/pint
check_error "Failed to install Laravel Pint"

# Generovanie IDE helper súborov
php artisan ide-helper:generate
php artisan ide-helper:meta
php artisan ide-helper:models --nowrite

# Konfigurácia .env súboru
echo "Configuring .env file..."
if [ -f "../backend/.env.backup" ]; then
    cp ../.env.backup .env
    echo "Restored .env from backup"
else
    sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=pgsql/" .env
    sed -i "s/DB_HOST=.*/DB_HOST=asistanto-db/" .env
    sed -i "s/DB_PORT=.*/DB_PORT=5432/" .env
    sed -i "s/DB_DATABASE=.*/DB_DATABASE=asistanto_db/" .env
    sed -i "s/DB_USERNAME=.*/DB_USERNAME=asistanto_user/" .env
    sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=secret/" .env

    # CORS a Session konfigurácia
    echo "SANCTUM_STATEFUL_DOMAINS=localhost:3001,localhost:3002,localhost:3003" >> .env
    echo "SESSION_DOMAIN=localhost" >> .env
    echo "CORS_ALLOWED_ORIGINS=http://localhost:3001,http://localhost:3002,http://localhost:3003" >> .env
fi

# Vytvorenie základných migrácií a modelov
echo "Creating base migrations and models..."

# Vytvorenie modelov
php artisan make:model Person -m
php artisan make:model Employee -m
php artisan make:model Place -m
php artisan make:model InventoryItem -m
php artisan make:model Machine -m
php artisan make:model Vehicle -m
php artisan make:model AttendanceRecord -m
php artisan make:model WorkRecord -m
php artisan make:model MaterialRecord -m
php artisan make:model TransportRecord -m
php artisan make:model CashRecord -m
php artisan make:model Quote -m
php artisan make:model Order -m
php artisan make:model Invoice -m

# Vytvorenie kontrolérov
php artisan make:controller PersonController --resource --api
php artisan make:controller EmployeeController --resource --api
php artisan make:controller PlaceController --resource --api
php artisan make:controller InventoryController --resource --api
php artisan make:controller MachineController --resource --api
php artisan make:controller VehicleController --resource --api
php artisan make:controller AttendanceController --resource --api
php artisan make:controller WorkRecordController --resource --api
php artisan make:controller MaterialRecordController --resource --api
php artisan make:controller TransportRecordController --resource --api
php artisan make:controller CashRecordController --resource --api
php artisan make:controller QuoteController --resource --api
php artisan make:controller OrderController --resource --api
php artisan make:controller InvoiceController --resource --api

# Nastavenie permissions a roles
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# Vytvorenie storage linku
php artisan storage:link

# Inštalácia front-end závislostí pre budúce potreby
npm install

# Obnovenie .git ak existoval
cd ..
if [ -d "backend.git.tmp" ]; then
    mv backend.git.tmp backend/.git
    echo "Restored .git directory"
fi

echo "Laravel 11 installation completed successfully!"
echo "Remember to:"
echo "1. Review and update migrations in database/migrations/"
echo "2. Configure Sanctum and CORS in config/"
echo "3. Set up roles and permissions"
echo "4. Update model relationships"