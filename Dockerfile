FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev sqlite3 libsqlite3-dev nodejs npm \
    && docker-php-ext-install pdo pdo_sqlite zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build

RUN touch database/database.sqlite

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

RUN chmod -R 775 storage bootstrap/cache database

RUN a2enmod rewrite

COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["sh", "-c", "php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan l5-swagger:generate && php artisan migrate --seed --force && apache2-foreground"]
