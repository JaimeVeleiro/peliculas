#!/bin/bash

# Variables
PHP_APACHE_IMAGE="veleiroruiz_php"
PHP_CONTAINER_PREFIX="veleiroruiz-web"
START_PHP_PORT=8081
NUM_CONTAINERS=$1
NUM_CONTAINERS2=$1
HAPROXY_CONFIG="./haproxy.cfg"
NETWORK_NAME="CICD"

# Creacion de network
docker network rm $NETWORK_NAME
docker network create $NETWORK_NAME

# Creacion contenedores PHP-apache
echo "Se crean los $NUM_CONTAINERS contenedores de PHP-Apache"
for j in $(seq 1 $NUM_CONTAINERS); do
    PHP_CONTAINER_NAME="${PHP_CONTAINER_PREFIX}${j}"
    PHP_PORT=$((START_PHP_PORT + j - 1))

    echo "Starting PHP-Apache container ${PHP_CONTAINER_NAME} en el puerto ${PHP_PORT}..."
    docker run -d --name "veleiroruiz-web${j}" -e PUERTO=${PHP_PORT} -e NOMBRE_CONT=$"php-veleiro${j}" -p "${PHP_PORT}:80" \
        -v .:/var/www/html --network $NETWORK_NAME \
        $PHP_APACHE_IMAGE
    echo ""
done

# Se reescribe la configuracion de haproxy con los nuevos servidores qeu acabamos de crear
echo "Escribribimos la configuración de haproxy"
cat > "${HAPROXY_CONFIG}" <<EOL
defaults
  mode http
  timeout client 10s
  timeout connect 5s
  timeout server 10s
  timeout http-request 10s
  log global

frontend stats
  bind *:8404
  stats enable
  stats uri /
  stats refresh 5s

frontend myfrontend
  bind *:80
  default_backend webservers

backend webservers
EOL
echo ""

# Agregar servidores
echo "Agregamos los servidores que acabamos de crear a la configuracion de haproxy"
for i in $(seq 1 $NUM_CONTAINERS2); do
    PORT=$((START_PHP_PORT + i - 1))
    echo "    server ${PHP_CONTAINER_PREFIX}${i} 127.0.0.1:${PORT} check" >> "${HAPROXY_CONFIG}"
done
echo "Archivo de configuracion completo"

echo ""

# Apertura Haproxy
docker run -d \
  --name haproxy \
  --network $NETWORK_NAME \
  -p 8181:80 \
  -p 8404:8404 \
  -v $HAPROXY_CONFIG:/usr/local/etc/haproxy/haproxy.cfg \
  haproxy:latest

echo ""

echo "SCRIPT COMPLETO!!"