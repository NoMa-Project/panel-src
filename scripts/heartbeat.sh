#!/bin/bash

# Récupération des paramètres
IP=$1
USER=$2
PASSWORD=$3
PORT=$4
URL=$7

sshpass -p "$PASSWORD" ssh -T -p "$PORT" "$USER"@$IP << EOF
  curl -X POST $url
EOF