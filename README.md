###DESCRIPTION

This is an app written in PHP that tracks a many to many relationship between Stores and Brands.

You will seriously be like: **"Muricah"**

###SQL Commands

`mysql.server start`
`mysql -uroot -proot`
`CREATE DATABASE shoes;`
`CREATE TABLE stores (name VARCHAR (255), id serial PRIMARY KEY);`
`CREATE TABLE brands (name VARCHAR (255), id serial PRIMARY KEY);`
`CREATE TABLE brands_stores (id serial PRIMARY KEY, brand_id INT, store_id INT);`
(copy shoes database into shoes_test via phpMyAdmin)

###COPYRIGHT INFORMATION

GPL v2

###LICENSE INFORMATION

GPL v2

###AUTHOR

Ben Pritchard

ben.s.pritchard@gmail.com
