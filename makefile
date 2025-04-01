APP_CONTAINER = checkout-laravel-app-1
DOCKER_COMPOSE = docker-compose

.PHONY: help up down artisan composer npm shell

help:
	@echo "Comandos disponíveis:"
	@echo "  make up         - Inicia os containers (docker-compose up -d)"
	@echo "  make down       - Para e remove os containers (docker-compose down)"
	@echo "  make artisan    - Executa comandos do Artisan. Ex: make artisan migrate"
	@echo "  make composer   - Executa comandos do Composer. Ex: make composer install"
	@echo "  make npm        - Executa comandos do NPM. Ex: make npm run dev"
	@echo "  make shell      - Abre um shell interativo no container da aplicação"

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
