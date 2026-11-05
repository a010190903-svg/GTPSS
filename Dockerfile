FROM php:8.3-apache
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf
RUN sed -i 's/:80>/:8080>/' /etc/apache2/sites-available/000-default.conf
RUN echo "DirectoryIndex index1.php index.php" > /etc/apache2/conf-enabled/inicio.conf
COPY . /var/www/html/
RUN cp /var/www/html/Consultorio.jpg /var/www/html/consultorio.jpg
EXPOSE 8080
