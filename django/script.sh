#!/bin/bash
apt update
apt upgrade -y
apt install apache2 libapache2-mod-wsgi-py3 -y
systemctl start apache2
systemctl enable apache2

#get necessary informations from user
echo "Sitename cannot be wordpress."
read -p "Entrez le nom de votre site: " sitename
read -p "Entrez le nom de la base de données: " db_name
read -p "Entrez le nom d'utilisateur de la base de données: " db_user
read -s -p "Entrez le mot de passe de la base de données: " db_password

#install database
apt install mysql-server libmysqlclient-dev -y
systemctl start mysql
systemctl enable mysql

mysql -u root -p <<MYSQL_SCRIPT
CREATE DATABASE $db_name;
CREATE USER '$db_user'@'localhost' IDENTIFIED BY '$db_password';
GRANT ALL PRIVILEGES ON $db_name.* TO '$db_user'@'localhost';
FLUSH PRIVILEGES;
MYSQL_SCRIPT

#install pip & venv
apt install python3-venv python3-pip -y

#install django using virtualenv
mkdir /var/www/$sitename 
cd /var/www/$sitename 
python3 -m venv django_env
source django_env/bin/activate
pip install django
pip install mysqlclient

#config hosts file
myip=$(ip a s dev ens33 | awk '/inet /{print $2}' | cut -d/ -f1)
echo "$myip $sitename.com" >> /etc/hosts

#create django project
django-admin startproject django_app .
sed -i '/^ALLOWED_HOSTS/d' /var/www/$sitename/django_app/settings.py
echo "ALLOWED_HOSTS = ['127.0.0.1', '$myip', '$sitename.com']" >> /var/www/$sitename/django_app/settings.py

sed -i '/^DATABASES = {/,/^}/d' /var/www/$sitename/django_app/settings.py
echo "DATABASES = {" >> /var/www/$sitename/django_app/settings.py
echo "    'default': {" >> /var/www/$sitename/django_app/settings.py
echo "  'ENGINE': 'django.db.backends.mysql'," >> /var/www/$sitename/django_app/settings.py
echo "  'NAME': '$db_name'," >> /var/www/$sitename/django_app/settings.py
echo "  'USER': '$db_user'," >> /var/www/$sitename/django_app/settings.py
echo "  'PASSWORD': '$db_password'," >> /var/www/$sitename/django_app/settings.py
echo "  'HOST': '127.0.0.1'," >> /var/www/$sitename/django_app/settings.py
echo "  'PORT' : '3306'," >> /var/www/$sitename/django_app/settings.py
echo "  }" >> /var/www/$sitename/django_app/settings.py
echo "}" >> /var/www/$sitename/django_app/settings.py

echo "import os" >> /var/www/$sitename/django_app/settings.py
echo "STATIC_URL='/static/'" >> /var/www/$sitename/django_app/settings.py
echo "STATIC_ROOT=os.path.join(BASE_DIR, 'static/')" >> /var/www/$sitename/django_app/settings.py
echo "MEDIA_URL='/media/'" >> /var/www/$sitename/django_app/settings.py
echo "MEDIA_ROOT=os.path.join(BASE_DIR, 'media/')" >> /var/www/$sitename/django_app/settings.py

#migrate the initial db schema to our mysql db
./manage.py makemigrations
./manage.py migrate

#create admin for the project
./manage.py createsuperuser
#admin
#email
#password

./manage.py collectstatic
deactivate

#config apache django
echo "<VirtualHost *:80>" >> /etc/apache2/sites-available/$sitename.conf
echo "        ServerName $sitename.com" >> /etc/apache2/sites-available/$sitename.conf
echo "        ServerAlias www.$sitename.com" >> /etc/apache2/sites-available/$sitename.conf
echo "        DocumentRoot /var/www/$sitename/" >> /etc/apache2/sites-available/$sitename.conf
echo "        ErrorLog \${APACHE_LOG_DIR}/$sitename.com_error.log" >> /etc/apache2/sites-available/$sitename.conf
echo "        CustomLog \${APACHE_LOG_DIR}/$sitename.com_access.log combined" >> /etc/apache2/sites-available/$sitename.conf
echo "        Alias /static /var/www/$sitename/static" >> /etc/apache2/sites-available/$sitename.conf
echo "        <Directory /var/www/$sitename/static>" >> /etc/apache2/sites-available/$sitename.conf
echo "                Require all granted" >> /etc/apache2/sites-available/$sitename.conf
echo "        </Directory>" >> /etc/apache2/sites-available/$sitename.conf
echo "        Alias /media /var/www/$sitename/media" >> /etc/apache2/sites-available/$sitename.conf
echo "        <Directory /var/www/$sitename/media>" >> /etc/apache2/sites-available/$sitename.conf
echo "                Require all granted" >> /etc/apache2/sites-available/$sitename.conf
echo "         </Directory>" >> /etc/apache2/sites-available/$sitename.conf
echo "        <Directory /var/www/$sitename/django_app>" >> /etc/apache2/sites-available/$sitename.conf
echo "                <Files wsgi.py>" >> /etc/apache2/sites-available/$sitename.conf
echo "                        Require all granted" >> /etc/apache2/sites-available/$sitename.conf
echo "                </Files>" >> /etc/apache2/sites-available/$sitename.conf
echo "        </Directory>" >> /etc/apache2/sites-available/$sitename.conf
echo "        WSGIDaemonProcess django_app python-path=/var/www/$sitename python-home=/var/www/$sitename/django_env" >> /etc/apache2/sites-available/$sitename.conf        
echo "        WSGIProcessGroup django_app" >> /etc/apache2/sites-available/$sitename.conf
echo "        WSGIScriptAlias / /var/www/$sitename/django_app/wsgi.py" >> /etc/apache2/sites-available/$sitename.conf
echo "</VirtualHost>" >> /etc/apache2/sites-available/$sitename.conf

a2dissite 000-default.conf 
a2ensite $sitename.conf
systemctl restart apache2

echo "Website $sitename successfully created !"
echo "Enter http://$sitename.com to connect to your website."

