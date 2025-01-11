#!/bin/bash

# Funkcia na nahradenie textu v súboroch
replace_in_file() {
    local file=$1
    local old=$2
    local new=$3

    if [[ "$OSTYPE" == "darwin"* ]]; then
        # macOS používa BSD sed
        sed -i '' "s/$old/$new/g" "$file"
    else
        # Linux používa GNU sed
        sed -i "s/$old/$new/g" "$file"
    fi
}

# Premenovanie adresárov
mv frontend-bootstrap frontend-employee
mv frontend-tailwind frontend-customer

# Aktualizácia docker-compose.yml
replace_in_file docker-compose.yml "frontend-bootstrap" "frontend-employee"
replace_in_file docker-compose.yml "frontend-tailwind" "frontend-customer"
replace_in_file docker-compose.yml "asistanto-bootstrap" "asistanto-employee"
replace_in_file docker-compose.yml "asistanto-tailwind" "asistanto-customer"

# Aktualizácia Dockerfile názvov
mv docker/Dockerfile-node-bootstrap docker/Dockerfile-node-employee
mv docker/Dockerfile-node-tailwind docker/Dockerfile-node-customer

# Aktualizácia obsahu v Dockerfile súboroch
replace_in_file docker/Dockerfile-node-employee "frontend-bootstrap" "frontend-employee"
replace_in_file docker/Dockerfile-node-customer "frontend-tailwind" "frontend-customer"

echo "Premenovanie frontendov dokončené!"
echo "Nezabudnite:"
echo "1. Aktualizovať dokumentáciu projektu"
echo "2. Commitnúť zmeny do git repozitára"
echo "3. Informovať tím o zmenách"