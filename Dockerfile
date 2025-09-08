FROM php:8.2-apache

# Crear carpeta public con index.php
RUN mkdir -p /var/www/html/public
RUN echo "<?php phpinfo(); ?>" > /var/www/html/public/index.php

# Configurar Apache
RUN sed -i "s!/var/www/html!/var/www/html/public!g" /etc/apache2/sites-available/000-default.conf
RUN printf '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>\n' >> /etc/apache2/apache2.conf

CMD ["apache2-foreground"]
