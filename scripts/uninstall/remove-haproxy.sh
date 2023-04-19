#!/bin/bash

#remove haproxy
systemctl stop haproxy
apt remove haproxy -y
apt remove --auto-remove haproxy
apt purge haproxy
apt purge --auto-remove haproxy

echo "Haproxy and dependencies successfully removed."