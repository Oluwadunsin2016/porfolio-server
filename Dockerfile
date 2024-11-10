# Use the official PHP image with Apache
FROM php:8.1-apache

# Install necessary PHP extensions
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    zip \
    libonig-dev && \
    docker-php-ext-install pdo pdo_mysql mbstring bcmath zip


# Set working directory
WORKDIR /var/www/html

# Copy the application code into the container
COPY . .

# Install Composer and dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer clear-cache && composer install --optimize-autoloader --no-dev -vvv

# Expose port 80
EXPOSE 80

# Start Apache server
# CMD ["apache2-foreground"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
