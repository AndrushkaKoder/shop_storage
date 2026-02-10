COMPOSE = docker compose
APP = php

up:
	${COMPOSE} up -d --build --remove-orphans

down:
	${COMPOSE} down

restart: down up

bash:
	${COMPOSE} exec ${APP} /bin/bash

validate:
	${COMPOSE} exec ${APP} /bin/bash -c "php bin/phpunit --testdox"
	${COMPOSE} exec ${APP} /bin/bash -c "php vendor/bin/php-cs-fixer fix"
	${COMPOSE} exec ${APP} /bin/bash -c "php vendor/bin/phpstan"
	${COMPOSE} exec ${APP} /bin/bash -c "php bin/console doctrine:schema:validate"



