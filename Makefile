-include .env

COMPOSER_EXE-=composer

tools/psalm/composer.lock:
	$(COMPOSER_EXE) --working-dir=tools/psalm install

tools/php-cs-fixer/composer.lock:
	$(COMPOSER_EXE) --working-dir=tools/php-cs-fixer install

.PHONY: psalm
psalm: tools/psalm/composer.lock
	tools/psalm/vendor/bin/psalm

.PHONY: php-cs-fixer
php-cs-fixer: tools/php-cs-fixer/composer.lock
	tools/php-cs-fixer/vendor/bin/php-cs-fixer fix
