FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    libexif-dev \  
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        exif \
        zip \
        intl \
        bcmath \
        opcache \
    && rm -rf /var/lib/apt/lists/*
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
