#!/bin/sh

/sbin/iptables -A OUTPUT -o lo -j ACCEPT
/sbin/iptables -A OUTPUT -m conntrack --ctstate RELATED,ESTABLISHED -j ACCEPT
/sbin/iptables -A OUTPUT -j REJECT
service mysql start
echo "CREATE DATABASE sqldemo; GRANT ALL ON sqldemo.* to 'username'@'localhost' IDENTIFIED BY 'password';" | mysql
/usr/bin/php /var/www/demos/sql/index.php reset=true
/usr/sbin/php5-fpm
/usr/sbin/nginx
