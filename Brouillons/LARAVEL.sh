#official laravel install

apt update -y && apt upgrade -y
apt install -y zip curl lsb-release apt-transport-https ca-certificates
add-apt-repository -y ppa:ondrej/php
apt install -y php8.1 php8.1-fpm php8.1-mysql php8.1-pgsql php8.1-sqlite3 php8.1-bcmath php8.1-mbstring php8.1-xml php8.1-curl php8.1-zip php8.1-gd

apt install apache2

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer


git clone https://github.com/MazBazDev/lan-bds.git
cd lan-bds
composer install
apt install npm && npm install -y

cp .env.example .env
php artisan serve
nano /etc/apache2/sites-enabled/000-default.conf #add path
systemctl restart apache2

chmod -R 755 /var/www/lan-bds
chown -R www-data:www-data /var/www/lan-bds
a2enmod rewrite
systemctl restart apache2

#add in /sites-enabled/000-default.conf
<Directory "/var/www/lan-bds">
    Options FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>


