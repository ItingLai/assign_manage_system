FROM php:8.1.28-apache
ADD . /var/www/html/
RUN docker-php-ext-install pdo pdo_mysql 
RUN a2enmod rewrite 
RUN service apache2 restart