COMPOSER=php -d=1G $(shell which composer)
DOCKER=docker-compose -f $(shell pwd)/docker/docker-compose.yml exec php

composer_req:
	${COMPOSER} require ${ARGS}
composer_autoload:
	${COMPOSER} dump-autoload
composer_install:
	${COMPOSER} install
composer_env:
	${COMPOSER} dump-env dev

analyze:
	php vendor/bin/phpstan analyse src --level 7

start:
	docker-compose -f $(shell pwd)/docker/docker-compose.yml up -d
stop:
	docker-compose -f $(shell pwd)/docker/docker-compose.yml down
rebuild_images:
	docker-compose -f $(shell pwd)/docker/docker-compose.yml build

test: composer_install composer_autoload
	php bin/phpunit

first_start: start
	composer_install
	composer_autoload
	${DOCKER} bin/console make:migrate --allow-no-migration -n
	${DOCKER} bin/console doctrine:fixtures:load -n