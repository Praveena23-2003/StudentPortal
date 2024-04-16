FROM php:8.0-apache

# Copy the contents of the PHP application to the Apache web server root directory
COPY . /var/www/html/

# Expose port 80 to the outside world
EXPOSE 80

# Update apt source URLs to use HTTPS
RUN sed -i 's/http:/https:/g' /etc/apt/sources.list

# Install PostgreSQL client and PHP extensions
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql
