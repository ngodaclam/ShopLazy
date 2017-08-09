#!/usr/bin/env bash
php artisan module:migrate-rollback service
php artisan module:migrate-rollback post
php artisan module:migrate-rollback core