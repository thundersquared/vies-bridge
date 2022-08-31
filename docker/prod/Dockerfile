# https://github.com/devilbox/docker-php-fpm
FROM devilbox/php-fpm:8.1-prod

LABEL maintainer="Anatoli Nicolae <devops@thundersquared.com>"
WORKDIR /var/www/default/htdocs
ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

# https://hub.docker.com/_/composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
COPY . /var/www/default/htdocs

RUN /usr/local/bin/composer install

# https://laravel.com/docs/9.x/octane#swoole
ENTRYPOINT /usr/local/bin/php -d variables_order=EGPCS /var/www/default/htdocs/artisan octane:start --server=swoole --host=0.0.0.0 --port=80
