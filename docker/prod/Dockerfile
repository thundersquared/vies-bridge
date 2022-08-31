FROM devilbox/php-fpm:8.1-prod

LABEL maintainer="Anatoli Nicolae <a.nicolae@pokerspa.it>"

WORKDIR /var/www/default/htdocs

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

COPY . /var/www/default/htdocs

ENTRYPOINT /usr/local/bin/php -d variables_order=EGPCS /var/www/default/htdocs/artisan octane:start --server=swoole --host=0.0.0.0 --port=80
