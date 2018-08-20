FROM debian:buster-slim
RUN apt-get update \
	&& apt-get install -y php7.0 \
	&& apt-get install -y apache2

RUN rm /var/www/html/*
COPY ./ /var/www/html/
RUN sed -i 's#\(AllowOverride.*\)[Nn]one#\1All#g' /etc/apache2/apache2.conf
RUN a2enmod rewrite
EXPOSE 80
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
