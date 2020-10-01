#!/usr/bin/sh
./bin/console doctrine:database:drop --if-exists --force --env=test
./bin/console doctrine:database:create --env=test
./bin/console doctrine:migrations:migrate --no-interaction --env=test
./bin/console database:load-fixtures --env=test
