PHP=`which php`

.DEFAULT: build
.PHONY: clean cronjob

install: | vendor
	echo "please add test"


check: PHP-exists

PHP-exists: ; @which php > /dev/null

composer.phar: check
	echo "Downloading composer."
	$(PHP) -r "readfile('https://getcomposer.org/installer');" | $(PHP)

vendor: composer.phar
	php composer.phar install --prefer-dist

clean:
	rm -rf vendor
