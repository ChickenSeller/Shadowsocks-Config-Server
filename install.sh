#!/bin/bash
read -p "Please enter your MySQL Database Host:" dbhost #输入数据库地址
read -p "Please enter your MySQL Database Name:" dbname #输入数据库名称
read -p "Please enter your MySQL Database Username:" username #输入数据库用户名
read -p "Please enter your MySQL Database Password:" password #输入数据库密码
touch .env
echo "APP_ENV=local" > .env
echo "APP_DEBUG=true" >> .env
echo "APP_KEY=" >> .env
echo "" >> .env
echo "DB_HOST=$dbhost" >> .env
echo "DB_DATABASE=$dbname" >> .env
echo "DB_USERNAME=$username" >> .env
echo "DB_PASSWORD=$password" >> .env
echo "" >> .env
echo "CACHE_DRIVER=file" >> .env
echo "SESSION_DRIVER=file" >> .env
echo "QUEUE_DRIVER=sync" >> .env
echo "" >> .env
echo "MAIL_DRIVER=smtp" >> .env
echo "MAIL_HOST=mailtrap.io" >> .env
echo "MAIL_PORT=2525" >> .env
echo "MAIL_USERNAME=null" >> .env
echo "MAIL_PASSWORD=null" >> .env
php artisan key:generate
chmod -R 777 storage
php artisan migrate
wget https://files.phpmyadmin.net/phpMyAdmin/4.5.2/phpMyAdmin-4.5.2-all-languages.zip
unzip phpMyAdmin-4.5.2-all-languages.zip