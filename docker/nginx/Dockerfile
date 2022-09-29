ARG VERSION=1.21.6-alpine

FROM nginx:${VERSION}

WORKDIR /var/www/html

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

COPY . .