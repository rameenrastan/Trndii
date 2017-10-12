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
3. Run `docker-compose up -d nginx mysql in trndiiapp/laradock` folder

## DB Migration:

1. Run `docker-compose exec workspace bash`  in laradock folder
2. Run `php artisan migrate:rollback`
3. Run `php artisan:migrate`
