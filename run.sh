#!/bin/sh

service mysql start
echo "CREATE DATABASE sqldemo; GRANT ALL ON sqldemo.* to 'username'@'localhost' IDENTIFIED BY 'password';" | mysql
/usr/sbin/php5-fpm
/usr/sbin/nginx
