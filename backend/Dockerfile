FROM php:8.1-cli
RUN docker-php-ext-install mysqli && pecl install redis && docker-php-ext-enable redis
COPY . /app
WORKDIR /app
CMD ["php", "-S", "0.0.0.0:8080"]
EXPOSE 8080
