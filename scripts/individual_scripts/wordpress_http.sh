#!/bin/bash
#this script creates n number of website (wordpress + database + link both)
#param : sitename, db_name, db_user, db_password, localhost (if db is not on localhost)


apt update -y && apt upgrade -y
#add-apt-repository -y ppa:ondrej/php
apt install apache2 ghostscript libapache2-mod-php mysql-server php php-bcmath php-curl php-imagick php-intl php-json php-mbstring php-mysql php-xml php-zip -y
clear

#get necessary informations from user
echo "Sitename cannot be wordpress."
read -p "Entrez le nom de votre site: " sitename
read -p "Entrez le nom de la base de données: " db_name
read -p "Entrez le nom d'utilisateur de la base de données: " db_user
read -s -p "Entrez le mot de passe de la base de données: " db_password
echo ""

#download and install wordpress
sudo mkdir -p /srv/www
sudo chown www-data: /srv/www
curl https://wordpress.org/latest.tar.gz | sudo -u www-data tar zx -C /srv/www
cp -r /srv/www/wordpress /srv/www/$sitename
rm -rf /srv/www/wordpress

#configuration of apache for wordpress
echo "<VirtualHost *:80>" >> /etc/apache2/sites-available/$sitename.conf
echo "ServerName $sitename.com" >> /etc/apache2/sites-available/$sitename.conf
echo "ServerAlias www.$sitename.com" >> /etc/apache2/sites-available/$sitename.conf
echo "DocumentRoot /srv/www/$sitename" >> /etc/apache2/sites-available/$sitename.conf
echo "<Directory /srv/www/$sitename>" >> /etc/apache2/sites-available/$sitename.conf
echo "Options FollowSymLinks" >> /etc/apache2/sites-available/$sitename.conf
echo "AllowOverride Limit Options FileInfo" >> /etc/apache2/sites-available/$sitename.conf
echo "DirectoryIndex index.php" >> /etc/apache2/sites-available/$sitename.conf
echo "Require all granted" >> /etc/apache2/sites-available/$sitename.conf
echo "</Directory>" >> /etc/apache2/sites-available/$sitename.conf
echo "<Directory /srv/www/$sitename/wp-content>" >> /etc/apache2/sites-available/$sitename.conf
echo "Options FollowSymLinks" >> /etc/apache2/sites-available/$sitename.conf
echo "Require all granted" >> /etc/apache2/sites-available/$sitename.conf
echo "</Directory>" >> /etc/apache2/sites-available/$sitename.conf
echo "</VirtualHost>" >> /etc/apache2/sites-available/$sitename.conf

#activate new site
a2ensite $sitename
a2enmod rewrite
a2dissite 000-default

#config hosts file
myip=$(ip a s dev ens33 | awk '/inet /{print $2}' | cut -d/ -f1)
echo "$myip $sitename.com" >> /etc/hosts
systemctl restart apache2

#configuration of database for wordpress
mysql -u root -p <<MYSQL_SCRIPT
CREATE DATABASE $db_name;
CREATE USER '$db_user'@'localhost' IDENTIFIED BY '$db_password';
GRANT ALL PRIVILEGES ON $db_name.* TO '$db_user'@'localhost';
FLUSH PRIVILEGES;
MYSQL_SCRIPT

#create wordpress configuration file
echo "<?php" >> /srv/www/$sitename/wp-config.php

# set file permissions
sudo chmod 640 /srv/www/$sitename/wp-config.php
sudo chown -R www-data:www-data /srv/www/$sitename/
sudo chmod -R 775 /srv/www/$sitename/

#configuration of wordpress to use this database
echo "define( 'DB_NAME', '$db_name' );" >> /srv/www/$sitename/wp-config.php
echo "define( 'DB_USER', '$db_user' );" >> /srv/www/$sitename/wp-config.php
echo "define( 'DB_PASSWORD', '$db_password' );" >> /srv/www/$sitename/wp-config.php
#attention : remplacer localhost par l'ip de la machine qui heberge la db
echo "define( 'DB_HOST', 'localhost' );" >> /srv/www/$sitename/wp-config.php
echo "define( 'DB_CHARSET', 'utf8' );" >> /srv/www/$sitename/wp-config.php
echo "define( 'DB_COLLATE', '' );" >> /srv/www/$sitename/wp-config.php
data=$(curl -s https://api.wordpress.org/secret-key/1.1/salt/)
echo "$data" >> /srv/www/$sitename/wp-config.php
echo "\$table_prefix = 'wp_';" >> /srv/www/$sitename/wp-config.php
echo "define( 'WP_DEBUG', false );" >> /srv/www/$sitename/wp-config.php
echo "if ( ! defined( 'ABSPATH' ) ) { define( 'ABSPATH', __DIR__ . '/' ); }" >> /srv/www/$sitename/wp-config.php
echo "require_once ABSPATH . 'wp-settings.php';" >> /srv/www/$sitename/wp-config.php
echo "?>" >> /srv/www/$sitename/wp-config.php
clear

echo "Le site web $sitename.com a été créé avec succès !"
echo "Enter $myip in your naviguator and follow the steps."
echo "Then you can just enter $sitename.com to access your site."