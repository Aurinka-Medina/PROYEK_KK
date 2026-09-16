#!/bin/sh
set -e

# Wait for PostgreSQL when DB_CONNECTION=pgsql
if [ "$DB_CONNECTION" = "pgsql" ]; then
  echo "Waiting for database $DB_HOST:$DB_PORT..."
  i=0
  until php -r "try { new PDO('pgsql:host='.getenv('DB_HOST').';port='.(getenv('DB_PORT') ?: 5432).';dbname='.getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); echo 'ok'; } catch (Exception \$e) { exit(1); }" >/dev/null 2>&1; do
    i=$((i+1))
    if [ $i -gt 60 ]; then
      echo "Database not reachable after 60s, continuing anyway"
      break
    fi
    sleep 1
  done
  echo "Database reachable"
fi

# Generate key only if empty/missing
if [ -z "$APP_KEY" ]; then
  echo "APP_KEY empty, generating..."
  php artisan key:generate --force || true
fi

php artisan migrate --force || echo "Migrate failed, continuing"

# Cache config/routes/views for prod
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

exec "$@"
