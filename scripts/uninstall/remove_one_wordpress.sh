#!/bin/bash

a2dissite $sitename
systemctl reload apache2 
rm -rf /var/www/$sitename
rm /etc/apache2/sites-available/$sitename.conf
rm /etc/ssl/certs/$sitename.crt
rm /etc/ssl/private/$sitename.key
apt autoremove

#remove database and user
read -p "Enter the database name: " db_name
read -p "Enter the database username: " db_user
mysql -u root -p <<MYSQL_SCRIPT
DROP DATABASE $db_name;
DROP USER '$db_user'@'localhost';
FLUSH PRIVILEGES;
MYSQL_SCRIPT