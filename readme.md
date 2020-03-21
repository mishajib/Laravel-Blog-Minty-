# Laravel Simple Blog Application
## Windows users:
- Download xampp: https://www.apachefriends.org/index.html
- Update windows environment variable path to point to your php install folder (inside xampp installation dir) (here is how you can do this http://stackoverflow.com/questions/17727436/how-to-properly-set-php-environment-variable-to-run-commands-in-git-bash)

## Mac Os, Ubuntu and windows users continue here:
- Create a database locally into project folder > database > database.sqlite file or create database into phpmyadmin and configure into .env file of laravel
- Download composer https://getcomposer.org/download/
- Pull project from git provider.
- Rename `.env.example` file to `.env`inside your project root and fill the database information.
  (windows wont let you do it, so you have to open your console cd your project root directory and run `mv .env.example .env` )
- Open the console and cd your project root directory
- Run `composer install` or ```php composer.phar install```
- Run `php artisan key:generate` 
- Run `php artisan migrate`
- Run `php artisan db:seed` to run seeders, if any.
- Run `php artisan serve`

##### You can now access your project at localhost:8000 :)

## If for some reason your project stop working do these:
- `composer install`
- `php artisan migrate`
