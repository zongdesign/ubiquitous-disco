#!/usr/bin/env bash
set -e

/var/www/bin/console assets:install public/
/var/www/bin/console doctrine:migrations:migrate -n
/var/www/bin/console doctrine:fixtures:load -n
chown www-data:www-data -R public var

$@