#!/usr/bin/env bash
# exit on error
set -o errexit

echo "--- Running Composer Install ---"
composer install --no-dev --no-interaction --prefer-dist

echo "--- Running NPM Install & Build ---"
npm install
npm run build

echo "--- Caching Laravel Configurations ---"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "--- Running Database Migrations ---"
php artisan migrate --force
