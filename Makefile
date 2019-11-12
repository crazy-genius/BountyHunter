COMPOSER=php -d=1G $(shell which composer)

composer_autoload:
	${COMPOSER} dump-autoload

composer_install:
	${COMPOSER} install

start:
	docker-compose -f $(shell pwd)/docker/docker-compose.yml up -d
stop:
	docker-compose -f $(shell pwd)/docker/docker-compose.yml down
rebuild_images:
	docker-compose -f $(shell pwd)/docker/docker-compose.yml build

