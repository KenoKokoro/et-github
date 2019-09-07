local-setup:
	@chmod +x docker/scripts/start.sh
	@cp .env.example .env
	@docker-compose -f docker-compose.yml -f dev.docker-compose.yml up -d --build
	@docker-compose exec --user=nginx app composer install
	@echo "\nRun unit tests"
	@docker-compose exec --user=nginx app vendor/bin/phpunit --testsuite "V1 Unit Tests" --coverage-html=storage/framework/coverage
	@echo "\nRun feature tests"
	@cp .env.behat .env
	@docker-compose exec --user=nginx app vendor/bin/behat --format=progress --suite v1
	@cp .env.example .env
	@echo "\nApplication is up and running!"

v1-behat:
	@cp .env.behat .env
	@docker-compose exec --user=nginx app vendor/bin/behat --format=progress --suite v1
	@cp .env.example .env

v1-phpunit-coverage:
	@cp .env.example .env
	@docker-compose exec --user=nginx app vendor/bin/phpunit --testsuite "V1 Unit Tests" --coverage-html=storage/framework/coverage

v1-phpunit:
	@cp .env.example .env
	@docker-compose exec --user=nginx app vendor/bin/phpunit --testsuite "V1 Unit Tests"
