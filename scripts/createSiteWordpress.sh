#!/bin/bash
#this script only creates wordpress

apt install apache2 php php-mysql wget

read -p "Entrez le nom du site web (sans www): " sitename

wget https://wordpress.org/latest.tar.gz
tar -xvzf latest.tar.gz
mv wordpress /var/www/
rm -rf latest.tar.gz
cp -r /var/www/wordpress /var/www/$sitename
chown -R www-data:www-data wordpress

sudo chmod -R 755 /var/www/$sitename

#config
echo "<VirtualHost *:80>" >> /etc/apache2/sites-available/$sitename.conf
echo "ServerName $sitename.com" >> /etc/apache2/sites-available/$sitename.conf
echo "ServerAlias www.$sitename.com" >> /etc/apache2/sites-available/$sitename.conf
echo "DocumentRoot /var/www/$sitename" >> /etc/apache2/sites-available/$sitename.conf
echo "ErrorLog ${APACHE_LOG_DIR}/error.log" >> /etc/apache2/sites-available/$sitename.conf
echo "CustomLog ${APACHE_LOG_DIR}/access.log combined" >> /etc/apache2/sites-available/$sitename.conf
echo "</VirtualHost>" >> /etc/apache2/sites-available/$sitename.conf

echo "192.168.121.128 $sitename.com" >> /etc/hosts

#activate
a2ensite $sitename.conf
systemctl restart apache2

echo "Le site web $sitename a été créé avec succès !"
