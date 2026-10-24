#!/bin/bash
set -e

# Dynamically set Apache port from Render's $PORT (default 80)
PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:$PORT>/g" /etc/apache2/sites-available/000-default.conf

# If using SQLite and database file doesn't exist, create it
if [ "${DB_CONNECTION}" = "sqlite" ] || [ -z "${DB_CONNECTION}" ]; then
    mkdir -p /var/www/html/database
    touch /var/www/html/database/database.sqlite
    chown -R www-data:www-data /var/www/html/database
    chmod 775 /var/www/html/database
    chmod 664 /var/www/html/database/database.sqlite
fi

# Ensure storage and upload directories exist and are writable
mkdir -p /var/www/html/storage/framework/{sessions,views,cache/data,cache/locks} /var/www/html/storage/logs /var/www/html/public/uploads/payment_screenshots
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/uploads
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/uploads

# Generate app key if missing
if [ -z "$APP_KEY" ]; then
    echo "Warning: APP_KEY is not set. Generating temporary key..."
    php artisan key:generate --force
fi

# Clear old cached files
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force || true

# Seed database with initial data if needed
if [ "$RUN_SEEDER" = "true" ]; then
    echo "Seeding database..."
    php artisan db:seed --force || true
fi

# Optimize Laravel cache for production
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Starting Apache on port $PORT..."
exec apache2-foreground
