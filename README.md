SQL Commands:

mysql.server start
mysql -uroot -proot
CREATE DATABASE shoes;
CREATE TABLE stores (name VARCHAR (255), id serial PRIMARY KEY);
CREATE TABLE brands (name VARCHAR (255), id serial PRIMARY KEY);
CREATE TABLE brands_stores (id serial PRIMARY KEY, brand_id INT, store_id INT);
(copy shoes database into shoes_test via phpMyAdmin)
