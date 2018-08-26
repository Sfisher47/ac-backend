FROM debian:buster-slim
RUN apt-get update \
	&& apt-get install -y php7.1 \
	&& apt-get install -y php7.1-gd php7.1-mysql \
	&& apt-get install -y apache2 \
	&& apt-get install -y git

WORKDIR /var/www/
RUN rm -rf html
RUN git clone https://github.com/elhmn/ac-backend
RUN cd ac-backend && git fetch --all && git checkout service
RUN mv ac-backend html
RUN sed -i 's#\(AllowOverride.*\)[Nn]one#\1All#g' /etc/apache2/apache2.conf

RUN sed -i '$ s#$#\nextension=pdo.so#' /etc/php/7.1/apache2/php.ini
RUN sed -i '$ s#$#\nextension=pdo_mysql.so#' /etc/php/7.1/apache2/php.ini

RUN a2enmod rewrite
ENV AC_ADMIN=admin
ENV AC_SCRIPT=php
EXPOSE 80
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
