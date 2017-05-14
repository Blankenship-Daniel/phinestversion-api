FROM eboraas/laravel

WORKDIR /var/www/laravel

COPY . /var/www/laravel

RUN apt-get update && apt-get install -y php5-sqlite && apt-get install -y php5-gd apt-get install -y cron && composer install

# Add crontab file in the cron directory
ADD crontab /etc/cron.d/updatedb-cron

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/updatedb-cron

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0
