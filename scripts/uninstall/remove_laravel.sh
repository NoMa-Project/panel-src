#!/bin/bash

#remove apache virtual host
read -p "Enter the site name: " sitename
a2dissite $sitename.conf
rm /etc/apache2/sites-available/$sitename.conf
systemctl restart apache2

#remove laravel project
rm -rf /var/www/$sitename

#remove ssl certificate
rm /etc/ssl/certs/$sitename.crt
rm /etc/ssl/private/$sitename.key

#remove database and user
read -p "Enter the database name: " db_name
read -p "Enter the database username: " db_user
mysql -u root -p <<MYSQL_SCRIPT
DROP DATABASE $db_name;
DROP USER '$db_user'@'localhost';
FLUSH PRIVILEGES;
MYSQL_SCRIPT

#remove php
apt remove -y php8.1 php8.1-fpm php8.1-mysql php8.1-pgsql php8.1-sqlite3 php8.1-bcmath php8.1-mbstring php8.1-xml php8.1-curl php8.1-zip php8.1-gd
add-apt-repository -r -y ppa:ondrej/php
apt autoremove -y

#remove apache and mysql
apt remove -y apache2 mysql-server libapache2-mod-php8.1
apt autoremove -y

#remove composer
rm /usr/local/bin/composer

echo "Uninstallation completed."
