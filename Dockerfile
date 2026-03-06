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

# Install PHP packages
RUN composer install --no-dev --optimize-autoloader

# Install Node packages
RUN npm install

# Build Vite assets
RUN npm run build

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD php -S 0.0.0.0:$PORT -t public
