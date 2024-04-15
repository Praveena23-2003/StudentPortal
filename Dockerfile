FROM php:8.0-apache

# Copy the contents of the PHP application to the Apache web server root directory
COPY . /var/www/html/

# Expose port 80 to the outside world
EXPOSE 80