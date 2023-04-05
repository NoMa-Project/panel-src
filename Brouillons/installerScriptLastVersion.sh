#!/bin/bash
normal=$(tput sgr0)
yellow=$(tput setaf 3)
green=$(tput setaf 2)
cyan=$(tput setaf 6)


function isRoot() {
  if [ "$EUID" -ne 0 ]; then
      return 1
  fi
}

function check_os() {
  os_distributor=$(lsb_release -si)
  if [ "$os_distributor" != "Debian" ] && [ "$os_distributor" != "Ubuntu" ]; then
    echo "Sorry, this script only supports Debian and Ubuntu. Your os distributor : $os_distributor"
    exit 1
  fi
}

function initial_check() {
  check_os
  if ! isRoot; then
    echo "Sorry, you need to run this as root"
    exit 1
  fi
}

function update_packages(){
  apt update -y
  apt upgrade -y
  echo "${green} Update & upgrade successfully completed ${normal}"
}

function isInstalled(){
  if command -v "$1" &> /dev/null
  then
    echo "${cyan} $1 is already installed ${normal}"
    return 0
  fi
   return 1
}

function aptinstall() {
  if [[ "$OS" =~ (debian|ubuntu) ]]; then
    apt -y install ca-certificates apt-transport-https dirmngr zip unzip lsb-release gnupg openssl curl wget
  fi
}

function install_apache2(){
  echo "${yellow} Starting apache2 installation... ${normal}"
  apt install -y apache2
  a2enmod rewrite
  wget -O /etc/apache2/sites-available/000-default.conf https://raw.githubusercontent.com/MaximeMichaud/Azuriom-install/master/conf/apache2/000-default.conf
  service apache2 restart
  mkdir /var/www/html/public
  echo "yo mazbaz" > /var/www/html/public/index.html
  echo "${green} Apache2 successfully installed ${normal}"
}

function install_mariadb(){
  echo "${yellow} Starting mariaDB installation... ${normal}"
  apt-key adv --fetch-keys 'https://mariadb.org/mariadb_release_signing_key.asc'
  add-apt-repository 'deb [arch=amd64] https://mirror.netcologne.de/mariadb/repo/10.6/ubuntu focal main'
  apt update
  apt install -y mariadb-server
  systemctl start mariadb
  echo "${green} Mariadb successfully installed ${normal}"
}

function install_php(){
  echo "${yellow} Starting PHP installation... ${normal}"
  curl -sSL -o /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg

  PHP="8.1"
        add-apt-repository -y ppa:ondrej/php
        apt-get update && apt-get install php$PHP{,-bcmath,-mbstring,-common,-xml,-curl,-gd,-zip,-mysql,-fpm} -y
        sed -i 's|upload_max_filesize = 2M|upload_max_filesize = 50M|' /etc/php/$PHP/apache2/php.ini
        sed -i 's|post_max_size = 8M|post_max_size = 50M|' /etc/php/$PHP/apache2/php.ini
        sed -i 's|;max_input_vars = 1000|max_input_vars = 2000|' /etc/php/$PHP/apache2/php.ini
        sed -i 's|memory_limit = 128M|memory_limit = 256M|' /etc/php/$PHP/fpm/php.ini
        service php$PHP-fpm restart
        systemctl restart apache2
  echo "${green} PHP successfully installed ${normal}"
}

function install_phpmyadmin(){
  echo "${yellow} Starting phpMyAdmin installation... ${normal}"

  #if os =~ (debian|ubuntu)
  PHPMYADMIN_VER=$(curl -s "https://api.github.com/repos/phpmyadmin/phpmyadmin/releases/latest" | grep -m1 '^[[:blank:]]*"name":' | cut -d \" -f 4)
  mkdir -p /usr/share/phpmyadmin/ || exit
  wget https://files.phpmyadmin.net/phpMyAdmin/"$PHPMYADMIN_VER"/phpMyAdmin-"$PHPMYADMIN_VER"-all-languages.tar.gz -O /usr/share/phpmyadmin/phpMyAdmin-"$PHPMYADMIN_VER"-all-languages.tar.gz
  tar xzf /usr/share/phpmyadmin/phpMyAdmin-"$PHPMYADMIN_VER"-all-languages.tar.gz --strip-components=1 --directory /usr/share/phpmyadmin
  rm -f /usr/share/phpmyadmin/phpMyAdmin-"$PHPMYADMIN_VER"-all-languages.tar.gz

  # Create phpMyAdmin TempDir
  mkdir -p /usr/share/phpmyadmin/tmp || exit
  chown www-data:www-data /usr/share/phpmyadmin/tmp
  chmod 700 /usr/share/phpmyadmin/tmp
  randomBlowfishSecret=$(openssl rand -base64 22)
  sed -e "s|cfg\['blowfish_secret'\] = ''|cfg['blowfish_secret'] = '$randomBlowfishSecret'|" /usr/share/phpmyadmin/config.sample.inc.php >/usr/share/phpmyadmin/config.inc.php
  ln -s /usr/share/phpmyadmin /var/www/phpmyadmin

  #if webserver =~ apache2
  wget -O /etc/apache2/sites-available/phpmyadmin.conf https://raw.githubusercontent.com/MaximeMichaud/Azuriom-install/master/conf/apache2/phpmyadmin.conf
  a2ensite phpmyadmin
  systemctl restart apache2
  echo "systemctl restart done"
  echo "${green} PhpMyAdmin successfully installed ${normal}"
}

function install_nodeJs(){
  echo "${yellow} Starting node js installation... ${normal}"
  curl -sL https://deb.nodesource.com/setup_14.x | sudo -E bash -
  sudo apt install -y nodejs
  echo "${green} node js successfully installed ${normal}"
}

function install_composerV2(){
  apt install -y php-cli
  echo "${yellow} Starting composer v2 installation... ${normal}"
  curl -sS https://getcomposer.org/installer -o composer-setup.php
  HASH=`curl -sS https://composer.github.io/installer.sig`
  if [ "$(php -r "echo hash_file('SHA384', 'composer-setup.php');")" = "$HASH" ]; then
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    rm composer-setup.php
  fi
  chmod +x /usr/local/bin/composer
  echo "${green} Composer v2 successfully installed ${normal}"
}

function install_certbot(){
  echo "${yellow} Starting certbot installation... ${normal}"
  apt update
  apt install -y certbot python3-certbot-apache

  certbot --apache
  echo "${green} Certbot successfully installed ${normal}"
}

function install_laravel(){
  apt-get install -y mysql-server-8.0 mysql-client
  apt install -y php8.2-curl
  apt install -y php8.2-xml
  echo "${yellow} Starting laravel installation... ${normal}"
  composer create-project --prefer-dist laravel/laravel project_test1

  # Configuration de Laravel
  cd project_test1
  php artisan serve --host=192.168.121.128 --port=8080
  echo "ok laravel"
}

function script_main_server(){
#  update_packages
 # aptinstall

  isInstalled "apache2"
  if [[ $? -eq 1 ]]; then
    install_apache2
  fi

  isInstalled "mariadb"
  if [[ $? -eq 1 ]]; then
    install_mariadb
  fi

  isInstalled "php"
  if [[ $? -eq 1 ]]; then
    install_php
  fi

  isInstalled "phpmyadmin"
  if [[ $? -eq 1 ]]; then
    install_phpmyadmin
  fi

  isInstalled "node"
  if [[ $? -eq 1 ]]; then
    install_nodeJs
  fi

  isInstalled "composer"
  if [[ $? -eq 1 ]]; then
    install_composerV2
  fi

  isInstalled "certbot"
  if [[ $? -eq 1 ]]; then
    install_certbot
  fi

  isInstalled "php artisan"
  if [[ $? -eq 1 ]]; then
    install_laravel
  fi

}

function menu(){
  echo "What do you want to do ?"
  echo "        1) Create a main server"
  echo "        2) Create a slave server"
  echo "        3) Quit"
  until [[ "$MENU_OPTION" =~ ^[1-5]$ ]]; do
      read -rp "Select an option [1-3] : " MENU_OPTION
    done
    case $MENU_OPTION in
    1)
      echo "${yellow} Let's start installing... ${normal}"
      script_main_server;
      ;;
    2)
      echo "In process... Try again later"
      ;;
    3)
      exit 0
      ;;
    esac
}

 initial_check
 menu
