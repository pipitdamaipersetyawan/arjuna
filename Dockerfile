FROM php:8.2-cli

WORKDIR /app

# install extension yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    curl

# install php extensions
RUN docker-php-ext-install pdo_mysql mysqli gd zip

COPY . .

RUN curl -sS https://getcomposer.org/installer | php \
    && php composer.phar install --no-dev --optimize-autoloader

EXPOSE 8080

CMD php artisan migrate --force && php -S 0.0.0.0:$PORT -t public