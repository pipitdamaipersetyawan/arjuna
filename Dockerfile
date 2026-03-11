# ================================
# Base Image
# ================================
FROM php:8.2-cli

# ================================
# Install System Packages
# ================================
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    nodejs \
    npm

# ================================
# Install PHP Extensions
# ================================
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    gd

# ================================
# Install Composer
# ================================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ================================
# Set Working Directory
# ================================
WORKDIR /app

# ================================
# Copy Project
# ================================
COPY . .

# ================================
# Install Laravel Dependencies
# ================================
RUN composer install --no-dev --optimize-autoloader

# ================================
# Install Node Dependencies
# ================================
RUN npm install

# ================================
# Build Vite Assets
# ================================
RUN npm run build

# ================================
# Laravel Cache Optimization
# ================================
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear
RUN php artisan cache:clear

# ================================
# Storage Link
# ================================
RUN php artisan storage:link || true

# ================================
# Railway Port
# ================================
ENV PORT=8080

# ================================
# Start Laravel Server
# ================================
CMD php artisan serve --host=0.0.0.0 --port=$PORT
