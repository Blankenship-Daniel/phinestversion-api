FROM eboraas/laravel

WORKDIR /var/www/laravel

COPY . /var/www/laravel

RUN apt-get update && \
    apt-get install -y php5-sqlite && \
    apt-get install -y php5-gd && \
#    apt-get install -y cron && \
    apt-get install -y php5-curl && \
    apt-get install -y sqlite3 && \
    composer install

#ADD crontab /etc/cron.d/updatedb-cron

#RUN chmod 0644 /etc/cron.d/updatedb-cron

#RUN crontab crontab

#RUN touch /var/log/cron.log

EXPOSE 8000

#CMD cron && php artisan serve --host=0.0.0.0
CMD php artisan serve --host=0.0.0.0
