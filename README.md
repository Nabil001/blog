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
- Edit .htaccess as follows :
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [QSA,L]
```
- You can now access the website going on the address reaching the website's directory
