#!/usr/bin/sh
./bin/console doctrine:database:drop --if-exists --force --env=dev
./bin/console doctrine:database:create --env=dev
./bin/console doctrine:migrations:migrate --no-interaction --env=dev
./bin/console database:load-fixtures --env=dev
