# Gunakan image resmi PHP + Apache
FROM php:8.2-apache

# Install ekstensi PDO MySQL untuk koneksi database Anda
RUN docker-php-ext-install pdo pdo_mysql

# Salin seluruh file project ke dalam web server Apache
COPY . /var/www/html/

# Expose port 80 (standard HTTP)
EXPOSE 80