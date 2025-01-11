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
