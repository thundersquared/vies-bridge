#!/usr/bin/env bash
set -eux

# Run startup scripts
run-parts docker/prod/startup.1.d

# Start Octane
# https://laravel.com/docs/9.x/octane#swoole
php -d variables_order=EGPCS artisan octane:start --server=swoole --host=0.0.0.0 --port=8000
