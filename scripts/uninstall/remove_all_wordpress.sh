#!/bin/bash

systemctl reload apache2 
rm -rf /var/www/
rm -rf /etc/apache2/sites-available/
rm /etc/ssl/certs/*.crt
rm /etc/ssl/private/*.key
apt remove apache2 ghostscript libapache2-mod-php mysql-server php php-bcmath php-curl php-imagick php-intl php-json php-mbstring php-mysql php-xml php-zip -y
apt purge apache2 ghostscript libapache2-mod-php mysql-server php php-bcmath php-curl php-imagick php-intl php-json php-mbstring php-mysql php-xml php-zip
apt autoremove

#remove database and user
read -p "Enter the database name: " db_name
read -p "Enter the database username: " db_user
mysql -u root -p <<MYSQL_SCRIPT
DROP DATABASE $db_name;
DROP USER '$db_user'@'localhost';
FLUSH PRIVILEGES;
MYSQL_SCRIPT