FROM wordpress:6-php8.1-apache

# Copy custom theme into the container
COPY ./wp-content/themes/toga-racing /var/www/html/wp-content/themes/toga-racing

# Set recommended PHP settings
RUN echo "upload_max_filesize = 64M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 64M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini

# Enable mod_rewrite for pretty permalinks
RUN a2enmod rewrite

EXPOSE 80
