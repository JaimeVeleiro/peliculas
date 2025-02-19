#!/bin/bash

# Variables
PHP_CONTAINER_PREFIX="veleiroruiz-web"
NUM_CONTAINERS=$1

# Parar contenedores PHP-apache
echo "Se eliminaran los $NUM_CONTAINERS contenedores de PHP-Apache"
for j in $(seq 1 $NUM_CONTAINERS); do
    PHP_CONTAINER_NAME="${PHP_CONTAINER_PREFIX}${j}"

    echo "Parada del contenedor $PHP_CONTAINER_NAME${J} de PHP-Apache"
    docker stop "veleiroruiz-web${j}"
    echo ""
done

docker stop haproxy

# Liberacion de memoria eliminando los contenedores inactivos
echo "Libreamos la memoria de contenedores inactivos"
docker container prune -f

echo "Script se ha completado"