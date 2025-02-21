# Use an official PHP image with Apache
FROM php:8.0-apache

# Copy your PHP backend files into the container
COPY . /var/www/html/

# Enable Apache mod_rewrite if needed (optional)
RUN a2enmod rewrite

# Expose port 80
EXPOSE 8080
