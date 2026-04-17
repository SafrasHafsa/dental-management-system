#!/bin/bash
set -e

echo "==> Starting SmileCare Dental entrypoint..."

# Install PHP dependencies if vendor is missing
if [ ! -d "/var/www/html/vendor" ]; then
    echo "==> Running composer install..."
    composer install --no-interaction --optimize-autoloader
fi

# Install Node dependencies and build assets if node_modules is missing
if [ ! -d "/var/www/html/node_modules" ]; then
    echo "==> Running npm install..."
    npm install
fi

# Copy .env if not present
if [ ! -f "/var/www/html/.env" ]; then
    echo "==> Copying .env.example to .env..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Generate app key if not set
if grep -q "APP_KEY=$" /var/www/html/.env; then
    echo "==> Generating application key..."
    php artisan key:generate --no-interaction
fi

# Load .env variables into shell for use below
if [ -f "/var/www/html/.env" ]; then
    export $(grep -v '^#' /var/www/html/.env | grep -v '^\s*$' | xargs)
fi

# Wait for MySQL to be ready
echo "==> Waiting for MySQL (host=${DB_HOST})..."
until php -r "new PDO('mysql:host=${DB_HOST:-mysql};dbname=${DB_DATABASE:-dental_db}', '${DB_USERNAME:-dental_user}', '${DB_PASSWORD:-dental_pass}');" 2>/dev/null; do
    echo "   MySQL not ready yet, retrying in 3s..."
    sleep 3
done
echo "==> MySQL is ready!"

# Run migrations + seed on first run
if ! php artisan migrate:status 2>/dev/null | grep -q "Ran"; then
    echo "==> Running migrations..."
    php artisan migrate --no-interaction --force
    echo "==> Running seeders..."
    php artisan db:seed --no-interaction --force
fi

# Create storage symlink
if [ ! -L "/var/www/html/public/storage" ]; then
    php artisan storage:link
fi

# Build frontend assets if no build folder
if [ ! -d "/var/www/html/public/build" ] || [ -z "$(ls -A /var/www/html/public/build 2>/dev/null)" ]; then
    echo "==> Building frontend assets..."
    npm run build
fi

# Cache config, routes and views for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> SmileCare Dental is ready!"

exec php-fpm
