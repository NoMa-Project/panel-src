#!/bin/bash

# Affectation des paramètres à des variables
ip=$1
user=$2
password=$3
port=$4
url=$5

# Connexion SSH au serveur distant
sshpass -p $password ssh -p $port $user@$ip echo $password | sudo -u $user -S curl -X POST $url 

# Vérification de la création du dossier
if [ $? -eq 0 ]
then
  echo "Connection to the node made successfully !"
else
  echo "Error while binding to node !"
fi
