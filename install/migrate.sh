#!/usr/bin/env bash
sh install/migrate-rollback.sh
php artisan module:migrate core
php artisan module:migrate post
php artisan module:migrate service

php artisan module:seed core
php artisan module:seed post
php artisan module:seed service