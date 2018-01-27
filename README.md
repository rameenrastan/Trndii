# TRNDii


## Team Members:
- Jacqueline Luo (26938949) / [LordRoost](https://github.com/LordRoost)
- Michael Mescheder (27202202) / [michaelgoldfish](https://github.com/michaelgoldfish)
- Sam Alexander Moosavi (27185731) / [sammoosavi](https://github.com/sammoosavi)
- Eric Payette (27008058) / [mosquitodawg](https://github.com/mosquitodawg)
- Rameen Rastan-Vadiveloo (27191863) / [rameenrastan](https://github.com/rameenrastan)
- Jason Tsalikis (25892120) / [jason10129](https://github.com/jason10129)

## Installation:
1. Run `git clone https://github.com/Laradock/laradock.git` in trndiiapp folder
2. Run `composer install` in trndiiapp folder
3. Run `docker-compose up -d nginx mysql` in trndiiapp/laradock folder

## DB Migration:

1. Run `docker-compose exec workspace bash`  in laradock folder
2. Run `php artisan migrate:refresh`
3. Run `php artisan db:seed` to populate database with test data

## dusk tests:

1. Run `php artisan dusk` in trndiiapp folder

## Vue.js and SASS:

- install Node.js
- run `npm install`
- run `npm run watch`  in trndiiapp folder

### For SASS:
- Add new SASS/CSS properties in resources/sass/app.scss

### For Vue.js:
- Create new vue components in /resources/assets/js/components
- Register components in app.js (i.e. Vue.component('example', require('./components/Example.vue'));)
- Import components into appropriate blade file. 

## Web  Server : 

- ec2-13-58-123-55.us-east-2.compute.amazonaws.com

## Jenkins Server : 

- ec2-13-58-123-55.us-east-2.compute.amazonaws.com:8080

- username: trndii
- password: trndii123
