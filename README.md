
## Installation steps

### Prerequisites
- Install composer (https://getcomposer.org/doc/00-intro.md), set path in enviroment variables to point to composer 
- Install docker on your local machine (https://www.docker.com/get-docker)
- Install php on your local machine (http://php.net/manual/en/install.windows.php)

### Installation:

- Move trndiiapp environment file in `Configuration and installation` folder into trndiiapp, rename to .env
- Run `git clone https://github.com/Laradock/laradock.git` in trndiiapp folder
- Move laradock environment file in `Configuration and installation` folder into laradock, rename to .env
- Run `composer install` in trndiiapp folder
- Run `docker-compose up -d nginx mysql` in trndiiapp/laradock folder

### DB Migrations
- Run `docker-compose exec workspace bash` in laradock folder
- Run `php artisan migrate:refresh`
- Run `php artisan db:seed` to populate database with test data

### Other
- Jenkins CI server: http://ec2-13-59-227-206.us-east-2.compute.amazonaws.com:8080 (username: trndii, password: trndii123)
- Logging Platform (Loggly): trndii.loggly.com (username: trndii, password: Trndii123)
