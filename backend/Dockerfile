# Use an official PHP runtime as a parent image
FROM php:8.0-fpm

# Set the working directory to /app
WORKDIR /var/www/html

COPY composer.json /var/www/html/


# Install dependencies
RUN apt-get update && apt-get install -y \
build-essential \
libzip-dev \
zip \
unzip \
libonig-dev \
libxml2-dev \
curl && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath && \
    pecl install -o -f redis && \
    rm -rf /tmp/pear && \
    docker-php-ext-enable redis && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the rest of the application
COPY . /var/www/html

# Generate autoload files
RUN composer install --no-scripts --no-autoloader && \
    composer dump-autoload --no-scripts --no-dev --optimize

# Set the environment variables
ENV APP_ENV=production
ENV APP_DEBUG=false

# Expose port 9000 and start php-fpm server
EXPOSE 8000
CMD ["php-fpm"]
