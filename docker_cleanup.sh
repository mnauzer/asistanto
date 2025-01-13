#!/bin/bash

# Farby pre výstup
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Funkcia na výpis správy s časovou značkou
log_message() {
    echo -e "${GREEN}[$(date +'%Y-%m-%d %H:%M:%S')]${NC} $1"
}

# Funkcia na výpis varovania
log_warning() {
    echo -e "${YELLOW}[VAROVANIE]${NC} $1"
}

# Funkcia na výpis chyby
log_error() {
    echo -e "${RED}[CHYBA]${NC} $1"
}

# Funkcia na zastavenie všetkých bežiacich kontajnerov
stop_containers() {
    log_message "Zastavujem všetky bežiace kontajnery..."
    running_containers=$(docker ps -q)
    if [ ! -z "$running_containers" ]; then
        docker stop $running_containers
        log_message "Všetky kontajnery boli zastavené."
    else
        log_message "Žiadne bežiace kontajnery."
    fi
}

# Funkcia na vymazanie všetkých kontajnerov
remove_containers() {
    log_message "Odstraňujem všetky kontajnery..."
    containers=$(docker ps -aq)
    if [ ! -z "$containers" ]; then
        docker rm -f $containers
        log_message "Všetky kontajnery boli odstránené."
    else
        log_message "Žiadne kontajnery na odstránenie."
    fi
}

# Funkcia na vymazanie všetkých images
remove_images() {
    log_message "Odstraňujem všetky Docker images..."
    images=$(docker images -q)
    if [ ! -z "$images" ]; then
        docker rmi -f $images
        log_message "Všetky images boli odstránené."
    else
        log_message "Žiadne images na odstránenie."
    fi
}

# Funkcia na vymazanie všetkých volumes
remove_volumes() {
    log_message "Odstraňujem všetky Docker volumes..."
    docker volume prune -f
    log_message "Všetky nepoužívané volumes boli odstránené."
}

# Funkcia na vymazanie všetkých sietí
remove_networks() {
    log_message "Odstraňujem všetky nepoužívané Docker siete..."
    docker network prune -f
    log_message "Všetky nepoužívané siete boli odstránené."
}

# Funkcia na vyčistenie cache
clean_cache() {
    log_message "Čistím Docker cache..."
    docker system prune -f
    log_message "Docker cache bolo vyčistené."
}

# Hlavné menu
show_menu() {
    echo -e "\n${GREEN}=== Docker Cleanup Script ===${NC}"
    echo "1) Zastaviť všetky kontajnery"
    echo "2) Vymazať všetky kontajnery"
    echo "3) Vymazať všetky images"
    echo "4) Vymazať všetky volumes"
    echo "5) Vymazať všetky nepoužívané siete"
    echo "6) Vyčistiť Docker cache"
    echo "7) !!! Kompletné vyčistenie (všetko vyššie) !!!"
    echo "8) Ukončiť"
    echo -e "${YELLOW}Vyberte možnosť (1-8):${NC} "
}

# Hlavná logika
while true; do
    show_menu
    read -r opt

    case $opt in
        1) stop_containers ;;
        2) remove_containers ;;
        3) remove_images ;;
        4) remove_volumes ;;
        5) remove_networks ;;
        6) clean_cache ;;
        7)
            log_warning "Toto vymaže VŠETKY Docker kontajnery, images, volumes a cache!"
            echo -e "${YELLOW}Ste si istý? (a/n):${NC} "
            read -r confirm
            if [ "$confirm" = "a" ]; then
                stop_containers
                remove_containers
                remove_images
                remove_volumes
                remove_networks
                clean_cache
                log_message "Kompletné čistenie dokončené!"
            fi
            ;;
        8)
            log_message "Ukončujem script..."
            exit 0
            ;;
        *)
            log_error "Neplatná voľba!"
            ;;
    esac
done