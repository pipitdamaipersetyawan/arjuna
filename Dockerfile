FROM php:8.2-cli

WORKDIR /app

# Install system packages
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    nodejs \
    npm

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql mysqli zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Install frontend dependencies
RUN npm install

# Build Vite assets
RUN npm run build

# Permission Laravel
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

# Clear cache agar Railway variables terbaca
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan view:clear && \
    php artisan route:clear && \
    php artisan serve --host=0.0.0.0 --port=8080
