FROM php:8.1-apache

WORKDIR /var/www/html

RUN docker-php-ext-install mysqli pdo pdo_mysql

# gawe htacces rewrite modul
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN echo '<Directory /var/www/html>\n\
       AllowOverride All\n\
   </Directory>' >> /etc/apache2/sites-available/000-default.conf

#    gawe perms
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

USER www-data
EXPOSE 80
