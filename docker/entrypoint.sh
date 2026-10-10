#!/bin/sh
set -e
cd /app

echo "Waiting for database..."
i=0
until php -r '
$host = getenv("DB_HOST") ?: "db";
$port = getenv("DB_PORT") ?: "3306";
$db   = getenv("DB_DATABASE") ?: "school";
$user = getenv("DB_USERNAME") ?: "root";
$pass = getenv("DB_PASSWORD") ?: "root";
try {
  new PDO("mysql:host={$host};port={$port};dbname={$db}", $user, $pass);
  exit(0);
} catch (Throwable $e) {
  exit(1);
}
'; do
  i=$((i + 1))
  if [ "$i" -gt 60 ]; then
    echo "Database not ready after 120s"
    exit 1
  fi
  sleep 2
done
echo "Database is ready."

php artisan migrate --force --no-interaction
php artisan db:seed --class=Database\\Seeders\\SiteAdminSeeder --force --no-interaction

# Mark app installed for AppServiceProvider / installer checks
touch storage/installed
chown www-data:www-data storage/installed 2>/dev/null || true

exec docker-php-entrypoint php-fpm
