#!/bin/bash
#this script only creates a page with welcome to $sitename

apt install apache2
read -p "Entrez le nom du site web : " sitename

mkdir -p /var/www/$sitename/public_html
echo "Welcome to $sitename!" | sudo tee /var/www/$sitename/public_html/index.html
sudo chmod -R 755 /var/www/$sitename

#config
echo "<VirtualHost *:80>" >> /etc/apache2/sites-available/$sitename.conf
echo "ServerName $sitename.com" >> /etc/apache2/sites-available/$sitename.conf
echo "ServerAlias www.$sitename.com" >> /etc/apache2/sites-available/$sitename.conf
echo "DocumentRoot /var/www/$sitename/public_html" >> /etc/apache2/sites-available/$sitename.conf
echo "ErrorLog ${APACHE_LOG_DIR}/error.log" >> /etc/apache2/sites-available/$sitename.conf
echo "CustomLog ${APACHE_LOG_DIR}/access.log combined" >> /etc/apache2/sites-available/$sitename.conf
echo "</VirtualHost>" >> /etc/apache2/sites-available/$sitename.conf

echo "192.168.121.128 $sitename.com" >> /etc/hosts

#activate
a2ensite $sitename.conf
systemctl restart apache2

echo "Le site web $sitename a été créé avec succès !"
