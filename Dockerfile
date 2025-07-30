FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy Docker environment file
COPY .env.docker .env

# Create fresh SQLite database
RUN rm -f database/database.sqlite
RUN mkdir -p database
RUN touch database/database.sqlite
RUN chmod -R 777 database

# Temporarily disable problematic migration
RUN mv database/migrations/2024_07_27_000000_update_cod_orders_payment_status.php database/migrations/2024_07_27_000000_update_cod_orders_payment_status.php.disabled

# Install dependencies
RUN composer install --no-interaction --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Configure Apache
RUN a2enmod rewrite
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Run Laravel setup
RUN php artisan key:generate --force
RUN php artisan migrate --force
RUN php artisan db:seed --force
RUN php artisan storage:link

EXPOSE 80
CMD ["apache2-foreground"]