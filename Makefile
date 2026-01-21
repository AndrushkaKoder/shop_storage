COMPOSE = docker compose
APP = app

up:
	${COMPOSE} up -d --build --remove-orphans

down:
	${COMPOSE} down

restart: down up
