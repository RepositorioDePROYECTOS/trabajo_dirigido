FROM nibrev/php-5.3-apache

RUN docker-php-ext-install gd

COPY . /var/www/html/planillas
