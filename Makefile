COMPOSE = docker compose
APP = php

up:
	${COMPOSE} up -d --build --remove-orphans

down:
	${COMPOSE} down

restart: down up

bash:
	${COMPOSE} exec ${APP} /bin/bash

doctrine:
	${COMPOSE} exec ${APP} /bin/bash -c "php bin/console doctrine:schema:validate"

