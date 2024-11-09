# Use the official PHP image with Apache
FROM php:8.1-apache

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy the application code into the container
COPY . .

# Install Composer and dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --optimize-autoloader --no-dev

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
