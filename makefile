APP_CONTAINER = checkout-laravel-app-1
DOCKER_COMPOSE = docker-compose

.PHONY: help up down artisan composer npm shell fresh build fresh-build composer-install env-copy

help:
	@echo "Comandos disponíveis:"
	@echo "  make up              - Inicia os containers (docker-compose up -d)"
	@echo "  make down            - Para e remove os containers (docker-compose down)"
	@echo "  make artisan         - Executa comandos do Artisan. Ex: make artisan migrate"
	@echo "  make composer        - Executa comandos do Composer. Ex: make composer install"
	@echo "  make composer-install- Executa 'composer install' no container"
	@echo "  make npm             - Executa comandos do NPM. Ex: make npm run dev"
	@echo "  make shell           - Abre um shell interativo no container da aplicação"
	@echo "  make fresh           - Executa 'php artisan migrate:fresh' no container"
	@echo "  make build           - Executa 'npm run build' no container"
	@echo "  make env-copy        - Copia .env.example para .env"

up:
	$(DOCKER_COMPOSE) up -d

down:
	$(DOCKER_COMPOSE) down

artisan:
	docker exec -it $(APP_CONTAINER) php artisan $(filter-out $@,$(MAKECMDGOALS))

composer:
	docker exec -it $(APP_CONTAINER) composer $(filter-out $@,$(MAKECMDGOALS))

npm:
	docker exec -it $(APP_CONTAINER) npm $(filter-out $@,$(MAKECMDGOALS))

shell:
	docker exec -it $(APP_CONTAINER) sh

fresh:
	$(MAKE) artisan migrate:fresh

build:
	$(MAKE) npm run build

composer-install:
	docker exec -it $(APP_CONTAINER) composer install

env-copy:
	cp .env.example .env
