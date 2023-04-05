#! /bin/bash
#this script only creates a database

echo "Enter database name : "
read databasename
echo "Enter username : "
read dbusername
echo "Enter password : "
read dbpassword

db1="create database $databasename;"
db2="use $databasename;"
db3="create user '$dbusername'@'localhost' identified by '$dbpassword';"
db4="GRANT ALL PRIVILEGES on $databasename.* to '$dbusername'@'localhost';"
db5="FLUSH PRIVILEGES;"
mysql -u root -e "$db1$db2$db3$db4$db5"

echo "ok"
#mysqlshow
