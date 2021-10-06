composer install # installs composer packages with composer.lock versions
composer update # updates composer packages
composer reset-db # rebuilds DB structure and data
composer ci # runs PHPUnit/PHPCS/PHPStan (check-code-validation)
composer lint # lints the project with "phpcs -ns"
composer fix # fixes code style with "phpcbf -wp"
composer phpunit # runs PHPUnit tests
composer phpstan # runs phpstan analyse
bin/console doctrine:migrations:migrate --no-interaction # runs all open migrations (d:m:m)
bin/console doctrine:fixtures:load --no-interaction # purges db and inserts fixtures instead (d:f:l)
bin/console form-builder:migrate:appointments # migrates appointments to form builder
bin/console c:c # clears the cache for current env (cache:clear)
composer setup-translation-files # copies translation files based on env
bin/console translation:setup-files # copies translation files based on env
composer coverage-full # Generate all Code Coverages (slow) [pcov muss an sein!]
BOOTSTRAP_CACHE_CLEAR=0 vendor/bin/infection --filter=src/CalendarCalculator -j$(nproc) --test-framework-options=" tests/Unit" --initial-tests-php-options="-d extension=pcov.so" # example of testing only one Folder and activate pcov only for initial coverage generation
