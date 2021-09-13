#### How to install WebNews

Install php 7.4

Install MySQL

Install composer

git clone https://github.com/0Jac0k19D01rupal0/WebNews.git folder

cd folder

composer install

define database, APP_KEY in .env

php artisan key:generate

php artisan migrate

php artisan db:seed

php artisan storage:link

php artisan serve


