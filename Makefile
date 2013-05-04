test:
	./bin/phpunit -c ./app

test-unit:
	./bin/phpunit -c ./app --group unit

test-functional:
	./bin/phpunit -c ./app --group functional

code-coverage:
	./bin/phpunit -c ./app --coverage-html ./docs/code-coverage
	open ./docs/code-coverage/index.html
