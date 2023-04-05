#!/bin/bash

a2dissite $sitename
systemctl reload apache2 
rm -rf /var/www/$sitename
rm /etc/apache2/sites-available/$sitename.conf
rm /etc/ssl/certs/$sitename.crt
rm /etc/ssl/private/$sitename.key
apt autoremove

