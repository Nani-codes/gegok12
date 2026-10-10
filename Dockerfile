FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    curl \
    zip \
    libxml2-dev \
    libicu-dev \
    libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ----------------------------
# Install Node.js (LTS version)
# ----------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && node -v \
    && npm -v

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Use /app (not /var/www) so Coolify's leftover ./ → /var/www mount cannot hide the code
WORKDIR /app

COPY docker/php.ini /usr/local/etc/php/conf.d/zz-laravel.ini

RUN git config --system --add safe.directory /app

COPY . /app

# Run as root — no composer.lock in git, so install must be able to write it
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts \
    && composer dump-autoload --optimize --no-scripts \
    && mkdir -p \
      storage/framework/cache \
      storage/framework/sessions \
      storage/framework/views \
      storage/logs \
      bootstrap/cache \
    && chown -R www-data:www-data /app \
    && chmod -R 775 storage bootstrap/cache
