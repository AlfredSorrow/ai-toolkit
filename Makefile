-include docker/.env
export $(test -e || shell sed 's/=.*//' docker/.env)

# common docker
DOCKER_COMPOSE_CMD = docker-compose
DOCKER_PHP_EXECUTE = docker exec web

## Show help
help:
	@printf "\033[33m%s:\033[0m\n" 'Доступные команды'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z0-9_-]+:.*?## / {printf "  \033[32m%-18s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

init: build start composer #migrate ## Init project

build: ## Build docker containers
	docker-compose build

start: ## Start docker containers
	${DOCKER_COMPOSE_CMD} up -d

composer: ## Install composer dependencies
	${DOCKER_PHP_EXECUTE} composer install --no-scripts --no-progress --no-cache --no-interaction

test: ## Run tests
	${DOCKER_PHP_EXECUTE} php bin/phpunit

shell: ## Enter to container
	docker exec -it web sh

stop: ## Stop docker containers
	${DOCKER_COMPOSE_CMD} stop

restart: stop start ## Restart docker containers

status: ## Show docker containers status
	${DOCKER_COMPOSE_CMD} ps

clean: ## Stop and remove docker containers
#	-docker-compose run --no-deps we sh -c "\
#    		php ./artisan config:clear; php ./artisan route:clear; php ./artisan view:clear; php ./artisan cache:clear file"
	${DOCKER_COMPOSE_CMD} down -v

migrate: ## Start migrations
	${DOCKER_PHP_EXECUTE} php artisan migrate --force
