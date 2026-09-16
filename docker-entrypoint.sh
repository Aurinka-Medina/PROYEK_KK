#!/bin/sh
set -e

# wait for MySQL when DB_HOST=db (or any non-localhost mysql)
if [ "$DB_CONNECTION" = "mysql" ] || [ "$DB_CONNECTION" = "mariadb" ]; then
  echo "Waiting for database $DB_HOST:$DB_PORT..."
  i=0
  until php -r "try { new PDO('mysql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); echo 'ok'; } catch (Exception \$e) { exit(1); }" >/dev/null 2>&1; do
    i=$((i+1))
    if [ $i -gt 60 ]; then
      echo "Database not reachable after 60s, continuing anyway"
      break
    fi
    sleep 1
  done
  echo "Database reachable"
fi

# ensure sqlite file exists when using sqlite
if [ "$DB_CONNECTION" = "sqlite" ]; then
  DB_PATH="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
  # handle default Laravel relative value database/database.sqlite
  if [ "$DB_PATH" = "database/database.sqlite" ] || [ "$DB_PATH" = "laravel" ]; then
    DB_PATH="/var/www/html/database/database.sqlite"
  fi
  if [ ! -f "$DB_PATH" ]; then
    echo "Creating sqlite file at $DB_PATH"
    touch "$DB_PATH"
    chown www-data:www-data "$DB_PATH" || true
  fi
fi

# generate key only if empty/missing
if [ -z "$APP_KEY" ]; then
  echo "APP_KEY empty, generating..."
  php artisan key:generate --force || true
fi

php artisan migrate --force || echo "Migrate failed, continuing"

# cache config/routes/views for prod, ignore failures
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

exec "$@"
