-include docker/.env
export $(test -e || shell sed 's/=.*//' docker/.env)

# common docker
DOCKER_COMPOSE_CMD = docker compose
DOCKER_PHP_EXECUTE = docker exec web

## Show help
help:
	@printf "\033[33m%s:\033[0m\n" 'Доступные команды'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z0-9_-]+:.*?## / {printf "  \033[32m%-18s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

init: build hooks start composer migrate ## Init project

build: ## Build docker containers
	${DOCKER_COMPOSE_CMD} build

start: ## Start docker containers
	${DOCKER_COMPOSE_CMD} up -d

migrate: ## Start migrations
	${DOCKER_PHP_EXECUTE} php bin/console d:m:m --no-interaction

composer: ## Install composer dependencies
	${DOCKER_PHP_EXECUTE} composer install --no-scripts --no-progress --no-cache --no-interaction

test: ## Run tests
	${DOCKER_PHP_EXECUTE} vendor/bin/codecept run

shell: ## Enter to container
	docker exec -it web sh

stop: ## Stop docker containers
	${DOCKER_COMPOSE_CMD} stop

hooks: ## Install git hooks (can be ingored with --no-verify flag)
	git config core.hooksPath ./hooks && chmod +x ./hooks/*

cache-clear: ## Clear cache
	${DOCKER_PHP_EXECUTE} bin/console cache:clear

restart: stop start cache-clear ## Restart docker containers

csfix: ## Fix code style
	${DOCKER_PHP_EXECUTE} vendor/bin/php-cs-fixer fix --verbose --show-progress=dots

csfix-show: ## Show code style errors
	${DOCKER_PHP_EXECUTE} vendor/bin/php-cs-fixer fix --verbose --show-progress=dots --allow-risky=yes --config=.php-cs-fixer-all.dist.php --dry-run

csfix-risky: ## Fix code style with risky
	${DOCKER_PHP_EXECUTE} vendor/bin/php-cs-fixer fix --verbose --show-progress=dots --allow-risky=yes --config=.php-cs-fixer-all.dist.php

phpstan: ## Запуск phpstan (статический анализ кода)
	${DOCKER_PHP_EXECUTE} vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=1024M

status: ## Show docker containers status
	${DOCKER_COMPOSE_CMD} ps

clean: ## Stop docker containers
	${DOCKER_COMPOSE_CMD} down -v
