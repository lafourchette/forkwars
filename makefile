PHP=`which php`

.DEFAULT: install
.PHONY: clean

install: | vendor

check: PHP-exists

PHP-exists: ; @which php > /dev/null

composer.phar: check
	echo "Downloading composer."
	$(PHP) -r "readfile('https://getcomposer.org/installer');" | $(PHP)

vendor: composer.phar
	php composer.phar install --prefer-dist

mrproper:
	rm -rf vendor

clean:
	rm -rf game.cache

test: | clean
	php -S localhost:8000
