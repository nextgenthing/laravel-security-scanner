FROM php:7.4-fpm

# Install additional dependencies or extensions as needed

# Copy your project files into the container
COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Run any additional commands or configurations required for your project

# Set the PHP version
RUN update-alternatives --set php /usr/bin/php7.4

# Expose the necessary ports
EXPOSE 80

CMD ["php-fpm"]