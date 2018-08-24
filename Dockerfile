FROM debian:buster-slim
RUN apt-get update \
	&& apt-get install -y php7.0 \
	&& apt-get install -y apache2 \
	&& apt-get install -y git

WORKDIR /var/www/
RUN rm -rf html
RUN git clone https://github.com/elhmn/ac-backend
RUN mv ac-backend html
RUN sed -i 's#\(AllowOverride.*\)[Nn]one#\1All#g' /etc/apache2/apache2.conf
RUN a2enmod rewrite
ENV AC_ADMIN=admin
ENV AC_SCRIPT=php
EXPOSE 80
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
