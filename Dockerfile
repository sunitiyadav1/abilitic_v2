# PHP Images can be found at https://hub.docker.com/_/php/
FROM php:7.3-alpine3.9

# The application will be copied in /var/www/html and the original document root will be replaced in the apache configuration 
COPY . /var/www/html/

# The application will be copied in /var/www/html and chown user:group and the original document root will be replaced in the apache configuration
COPY --chown=www-data:www-data . /var/www/html/

# Custom Document Root
ENV APACHE_DOCUMENT_ROOT /var/www/html/

# ssl certificates and ssl configs
#COPY ./config/ssl /etc/ssl/
#COPY ./config/customssl.conf /etc/apache2/conf.d/customssl.conf

# Concatenated RUN commands
RUN apk add --update libcap apache2 apache2-ssl php7-apache2 php7-mbstring php7-session php7-json php7-pdo php7-mysqli php7-ctype php7-iconv php7-zip php7-curl php7-openssl php7-tokenizer php7-pdo php7-pdo_mysql php7-xml php7-simplexml php7-xmlreader php7-xmlwriter libzip-dev zip php7-fileinfo php7-gd\
    #&& mkdir -p /var/www/html/core/storage \
    && mkdir -p /var/www/moodledata_abilitic_v2 \
    #&& chmod -R 777 /var/www/html/core/storage \
    && chmod -R 777 /var/www/moodledata_abilitic_v2 \
    && chown -R www-data:www-data /var/log /var/www/logs /etc/ssl /run/apache2/ \
    #&& chown -R www-data:www-data /var/www/html/ \
    && mkdir -p /run/apache2 \
    && sed -i '/LoadModule rewrite_module/s/^#//g' /etc/apache2/httpd.conf \
    && sed -i '/LoadModule session_module/s/^#//g' /etc/apache2/httpd.conf \
    && sed -ri 's!^(\s*ServerTokens\s+)\S+!\1Prod!g;' /etc/apache2/httpd.conf \
    && sed -ri 's!^(\s*ServerSignature\s+)\S+!\1Off!g;' /etc/apache2/httpd.conf \
    && sed -ri -e 's!/var/www/localhost/htdocs!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/httpd.conf \
    && sed -i 's/AllowOverride\ None/AllowOverride\ All/g' /etc/apache2/httpd.conf \
    && docker-php-ext-install mysqli pdo_mysql \
    && docker-php-ext-enable mysqli \
    && docker-php-ext-configure zip --with-libzip \ 
    && docker-php-ext-install zip \
    && rm  -rf /tmp/* /var/cache/apk/*


# Override with custom php.ini settings
#COPY ./config/php_custom.ini $PHP_INI_DIR/conf.d/   
#COPY ./config/php_custom.ini /etc/php7/conf.d/


#USER www-data

#RUN setcap 'cap_net_bind_service=+ep' /usr/sbin/httpd
#RUN getcap /usr/sbin/httpd

ENTRYPOINT ["/usr/sbin/httpd","-D","FOREGROUND"]

#ENTRYPOINT ["/var/www/html/config/env_secrets_expand.sh"]
# Launch the httpd in foreground
#CMD source /var/www/html/config/env_secrets_expand.sh || true && echo 'secrets configured now starting main server' && rm -rf /run/apache2/* || true && /usr/sbin/httpd -DFOREGROUND || true && echo 'server started successfully'
# expose 80 port
EXPOSE 81 80 443
HEALTHCHECK --interval=5s CMD curl -k --fail https://localhost:81/abilitic_v2/lmscore/ || exit 1

#USER www-data