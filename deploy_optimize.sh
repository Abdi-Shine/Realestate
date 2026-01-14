#!/bin/bash

# Laravel Deployment Optimization Script for Shared Hosting

echo "Starting optimization..."

# Clear caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Re-cache for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Optimization complete!"
