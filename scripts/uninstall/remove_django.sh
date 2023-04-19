#!/bin/bash

#stop & remove apache
systemctl stop apache2
systemctl disable apache2
apt remove --purge apache2 libapache2-mod-wsgi-py3 -y
apt autoremove -y

#delete the SSL certificate files
rm -f /etc/ssl/certs/$sitename.crt
rm -f /etc/ssl/private/$sitename.key

#delete the apache configuration file
rm -f /etc/apache2/sites-available/$sitename.conf
rm -f /etc/apache2/sites-enabled/$sitename.conf
systemctl restart apache2

#remove mysql
systemctl stop mysql
systemctl disable mysql
apt remove --purge mysql-server libmysqlclient-dev -y
apt autoremove -y

#remove the django
rm -rf /var/www/$sitename
systemctl restart apache2

#remove database
mysql -u root -p <<MYSQL_SCRIPT
DROP DATABASE IF EXISTS $db_name;
DROP USER IF EXISTS '$db_user'@'localhost';
MYSQL_SCRIPT

#remove pip and venv
apt remove --purge python3-pip python3-venv -y
apt autoremove -y

#remove the entry in /etc/hosts
myip=$(ip a s dev ens33 | awk '/inet /{print $2}' | cut -d/ -f1)
sed -i "/^$myip $sitename.com/d" /etc/hosts

#remove the script file
rm -f $0
clear
echo "Uninstallation completed."