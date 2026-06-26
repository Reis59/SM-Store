# 1. Menggunakan base image PHP + Nginx yang sudah siap pakai
FROM richarvey/nginx-php-fpm:php84

# 2. Mengatur folder kerja utama di dalam container
WORKDIR /var/www/html

# 3. Menyalin seluruh kode proyek Laravel local ke dalam container
COPY . .

# 4. Mengatur konfigurasi Environment untuk Production
ENV PHP_UPLOAD_MAX_FILESIZE 10M
ENV PHP_POST_MAX_SIZE 10M
ENV Web_DOCUMENT_ROOT /var/www/html/public

# 5. Menginstal dependensi PHP menggunakan Composer (Tanpa dev dependencies agar ringan)
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# 6. Memberikan hak akses (permission) folder storage & bootstrap agar Laravel bisa menulis log/cache
RUN chown -R nw-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 7. Membuka port 80 untuk akses web
EXPOSE 80

# 8. Menjalankan skrip startup bawaan image untuk menghidupkan Nginx dan PHP-FPM
CMD ["/start.sh"]