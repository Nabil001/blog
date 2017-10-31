# How to install this project
## Prerequisites
You need to install [git](https://git-scm.com/) and [composer](https://getcomposer.org/)
## Installation
- Clone the project in the wanted server's root directory
```
git clone https://github.com/Nabil001/blog.git
```
- Move to the directory, and run composer
```
composer install
```
- Create a folder 'config' at the root of the project, containing a 'pdo.xml' file, edited as follows :
```
<?xml version="1.0" encoding="UTF-8"?>
<pdo>
    <database host="[database server host IP adress]" dbname="[name of the blog posts database]" />
    <user id="[database user]" passwd="[database user's password]" />
</pdo>
```
(The text between brackets is to be replaced)
- Edit your server configuration file the virtual host so that the client typing the website URL is redirected to the project directory. This might look like this if you're using WAMP :
```
<VirtualHost *:80>
    ServerName blog.info
    DocumentRoot c:/wamp64/www/blog1/blog
    <Directory "c:/wamp64/www/blog1/blog">
       Options -Indexes -MultiViews -Includes +FollowSymLinks 
		AllowOverride All
		Require local
    </Directory>
</VirtualHost>
```
- Edit .htaccess as follows, so that the URL is correctly rewritten :
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [QSA,L]
```
- You can now access the website going on the address reaching the website's directory
