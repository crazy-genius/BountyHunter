COMPOSER=php -d=1G $(shell which composer)
DOCKER=docker-compose -f $(shell pwd)/docker/docker-compose.yml

composer_req:
	${COMPOSER} require ${ARGS}
composer_autoload:
	${COMPOSER} dump-autoload
composer_install:
	${COMPOSER} install
composer_env:
	${COMPOSER} dump-env dev

start:
	docker-compose -f $(shell pwd)/docker/docker-compose.yml up -d
	composer_install
	composer_autoload
	${DOCKER} migrations:migrate --allow-no-migration -n
	${DOCKER} php bin/console doctrine:fixtures:load -n

stop:
	docker-compose -f $(shell pwd)/docker/docker-compose.yml down
rebuild_images:
	docker-compose -f $(shell pwd)/docker/docker-compose.yml build

