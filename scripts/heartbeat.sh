#!/bin/bash

# Récupération des paramètres
IP=$1
USER=$2
PASSWORD=$3
PORT=$4
URL=$7

sshpass -p "$PASSWORD" ssh -T -p "$PORT" "$USER"@10.211.55.13 << EOF
  curl -X POST http://10.69.19.24:8043/api/heartbeat/8/a86a51e5d943d8e37d2636d345fcad25
EOF