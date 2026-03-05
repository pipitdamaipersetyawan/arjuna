FROM php:8.2-cli

WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libzip-dev \
    zip \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mysqli

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD php artisan migrate --force && php -S 0.0.0.0:$PORT -t public