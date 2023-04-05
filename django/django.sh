#!/bin/bash
apt update
apt upgrade -y
apt install apache2 libapache2-mod-wsgi-py3 -y
systemctl start apache2
systemctl enable apache2

#install database
apt install mysql-server libmysqlclient-dev -y
systemctl start mysql
systemctl enable mysql
mysql -u root
mysql> CREATE DATABASE django_db;
mysql> CREATE USER 'django_user'@'localhost' IDENTIFIED BY 'Pa$$word';
mysql> GRANT ALL ON django_db.* TO 'django_user'@'localhost';
mysql> FLUSH PRIVILEGES;
mysql> EXIT

#install pip & venv
apt install python3-venv python3-pip -y

#install django using virtualenv
mkdir /var/www/django_project 
cd /var/www/django_project
python3 -m venv django_env
source django_env/bin/activate
pip install django
pip install mysqlclient

#create django project
django-admin startproject django_app .
echo "ALLOWED_HOSTS = ['192.168.121.128', 'djangomyproject.com']" >> django_app/settings.py
#config django_app/settings.py
./manage.py  makemigrations
./manage.py  migrate
./manage.py createsuperuser
#admin
#email
#password
./manage.py collectstatic
deactivate

nano /etc/apache2/sites-available/django.conf

a2dissite 000-default.conf 