# https://github.com/devilbox/docker-php-fpm
FROM devilbox/php-fpm:8.1-prod

LABEL maintainer="Anatoli Nicolae <devops@thundersquared.com>"

# https://github.com/laravel/sail/blob/1da083e30e6b0d646535c0afc2afeffdccb7181d/runtimes/8.1/Dockerfile#L9-L12
WORKDIR /var/www/default/htdocs
ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

# https://hub.docker.com/_/composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
COPY . /var/www/default/htdocs

RUN /usr/local/bin/composer install

EXPOSE 8000

ENTRYPOINT docker/prod/entrypoint.sh
