#!/bin/bash

# Funkcia pre bezpečné vymazanie adresára
cleanup_frontend() {
    local dir=$1
    if [ -d "$dir" ]; then
        echo "Cleaning up $dir..."
        # Zachovanie .git ak existuje
        if [ -d "$dir/.git" ]; then
            mv "$dir/.git" "$dir.git.tmp"
        fi
        rm -rf "$dir"
        mkdir -p "$dir"
        if [ -d "$dir.git.tmp" ]; then
            mv "$dir.git.tmp" "$dir/.git"
        fi
        echo "$dir cleaned"
    else
        mkdir -p "$dir"
        echo "$dir created"
    fi
}

# Vyčistenie všetkých frontend adresárov
cleanup_frontend "frontend-admin"
cleanup_frontend "frontend-customer"
cleanup_frontend "frontend-employee"

echo "All frontend directories cleaned and ready for new installation"