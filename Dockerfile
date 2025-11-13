FROM php:8.2-fpm

# --- New/Modified Block for System and PHP Dependencies ---
# Install system dependencies, including libraries for GD (libfreetype, libjpeg, libpng)
RUN apt-get update && apt-get install -y \
    git curl unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    **libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev** \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions, including Pdo and the newly configured GD
RUN docker-php-ext-install pdo pdo_mysql mbstring zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install **gd**
# -----------------------------------------------------------

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel setup
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
# CMD ["php-fpm"]
