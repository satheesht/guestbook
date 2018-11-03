FROM php:7.2-fpm


# Install necessary packages
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    curl \
    libz-dev \
    libssl-dev \
    libmcrypt-dev \
    zip unzip \
    git

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Install composer and add its bin to the PATH.
RUN curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/detectify/src/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer

# Create the www-data user
RUN usermod -u 1000 www-data

COPY ./docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]

CMD ["php-fpm"]

EXPOSE 9000