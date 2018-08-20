#!/usr/bin/env bash

set -ex

export HOST_PORT=${HOST_PORT:=80}
export CONTAINER_PORT=${CONTAINER_PORT:=8080}
export COMPOSER_OPTIMIZE=${COMPOSER_OPTIMIZE:=false}

name='skellington'

cd "$(dirname "$0")"

docker build \
    -t ${name}:latest \
    --build-arg CONTAINER_PORT=${CONTAINER_PORT} \
    --build-arg COMPOSER_OPTIMIZE=${COMPOSER_OPTIMIZE} \
    ./..

docker rm -f ${name} || true

docker run \
    --name ${name} \
    -d \
    -p ${HOST_PORT}:${CONTAINER_PORT} \
    -v $PWD/../src:/var/www/src \
    -v $PWD/../vendor:/var/www/vendor \
    -v $PWD/../node_modules:/var/www/node_modules \
    ${name}:latest \
    /bin/sh -c "php /var/www/composer.phar install -v --working-dir=/var/www --no-suggest --no-dev && npm install && /var/www/compile-assets.sh && /var/www/run.sh"

docker logs -f ${name}
