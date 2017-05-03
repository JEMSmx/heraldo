#!/bin/bash
set -e

curl -fsSL https://github.com/memiux/cloud/tarball/master | tar --strip 1 -xzC $(mkdir -p ~/.cloud; echo $_)

# printf "\n" | pecl install imagick
# su vagrant -c 'cd /vagrant && composer.phar install'
mysql -u root -p123 -e "CREATE DATABASE IF NOT EXISTS heraldo CHARACTER SET utf8 COLLATE utf8_general_ci;"

# /usr/local/sbin/php-fpm --nodaemonize
# /usr/local/bin/httpd -D NO_DETACH
# sudo tail -f /var/log/syslog /var/log/upstart/*.log /var/log/mysql/error.log /tmp/*.log /vagrant/public/site/assets/logs/*.txt

apt-get install -y ruby2.0
gem2.0 install sass -v 3.4.22 --no-ri --no-rdoc

curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -
apt-get install -y build-essential nodejs
npm install -g uglify-js

echo -e $C_GREEN"Done"$C_0
