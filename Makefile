install:
	 composer install
lint:
	composer run-script phpcs -- --standard=PSR12 src bin
push:
	git push -u origin master
test:
	composer run-script phpunit tests
