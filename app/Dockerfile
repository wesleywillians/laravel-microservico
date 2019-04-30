        FROM php:7.3-fpm-alpine
        RUN apk add bash mysql-client
        RUN docker-php-ext-install pdo pdo_mysql

        WORKDIR /var/www
        RUN rm -rf /var/www/html
        # Install composer
        RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
        COPY . /var/www
        RUN composer install && \
            cp .env.example .env && \
            php artisan key:generate && \
            php artisan config:cache 

        RUN ln -s public html && \
            chmod -R 777 storage
            # vendor/bin/phpunit
        
        # Expose port 9000 and start php-fpm server
        EXPOSE 9000
        
        # ENTRYPOINT ["/var/www/entrypoint.sh"]
        # CMD ["php-fpm"]

