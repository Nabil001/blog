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
- Edit .htaccess as follows :
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [QSA,L]
```
- You can now access the website going on the address reaching the website's directory
