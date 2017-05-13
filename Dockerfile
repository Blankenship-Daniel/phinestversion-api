FROM eboraas/laravel

WORKDIR /var/www/laravel

COPY . /var/www/laravel

RUN apt-get update && apt-get install -y php5-sqlite && apt-get install -y php5-gd && composer install

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0
