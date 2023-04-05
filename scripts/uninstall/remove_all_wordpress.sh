#!/bin/bash

systemctl reload apache2 
rm -rf /var/www/
rm -rf /etc/apache2/sites-available/
rm /etc/ssl/certs/*.crt
rm /etc/ssl/private/*.key
apt remove apache2 ghostscript libapache2-mod-php mysql-server php php-bcmath php-curl php-imagick php-intl php-json php-mbstring php-mysql php-xml php-zip -y
apt purge apache2 ghostscript libapache2-mod-php mysql-server php php-bcmath php-curl php-imagick php-intl php-json php-mbstring php-mysql php-xml php-zip
apt autoremove

