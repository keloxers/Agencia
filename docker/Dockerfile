# Solo desarrollo local. Laravel 4.0 exige PHP 5.x + mcrypt: distroless no aplica.
FROM php:5.6-apache AS builder
RUN printf 'deb http://archive.debian.org/debian stretch main\n' > /etc/apt/sources.list \
 && apt-get -o Acquire::Check-Valid-Until=false update \
 && apt-get install -y --no-install-recommends --allow-unauthenticated libmcrypt-dev \
 && docker-php-ext-install mcrypt pdo_mysql \
 && mkdir -p /out/lib \
 && cp "$(php-config --extension-dir)"/mcrypt.so "$(php-config --extension-dir)"/pdo_mysql.so /out/ \
 && cp -L "$(ldconfig -p | awk '/libmcrypt\.so\.4/{print $NF; exit}')" /out/lib/libmcrypt.so.4

FROM php:5.6-apache AS runtime
COPY --from=builder /out/mcrypt.so /out/pdo_mysql.so /tmp/ext/
COPY --from=builder /out/lib/libmcrypt.so.4 /usr/lib/libmcrypt.so.4
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN mv /tmp/ext/*.so "$(php-config --extension-dir)"/ \
 && ldconfig \
 && docker-php-ext-enable mcrypt pdo_mysql \
 && a2enmod rewrite \
 && printf 'date.timezone=America/Argentina/Buenos_Aires\n' > /usr/local/etc/php/conf.d/tz.ini
WORKDIR /var/www/html
