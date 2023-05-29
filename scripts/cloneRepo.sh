#!/bin/bash

ip=$1
user=$2
password=$3
port=$4
url=$5

# Connexion SSH au serveur distant et création du fichier
sshpass -p $password ssh -p $port $user@$ip echo $password | sudo -u $user -S touch /var/www/helloworld
