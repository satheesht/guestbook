#!/bin/bash

cd /var/www/detectify
composer update

exec "$@"