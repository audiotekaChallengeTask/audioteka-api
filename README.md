### 1. Należy ustawić parametry .env zgodnie z konfiguracją środowiska
### 2. Należy zainstalować zależności przez composer'a
### 3. Należy utworzyć bazę 
#### a) dla środowiska `dev` wystarczy uruchomić `./recreate_database_dev.sh`
#### a) dla środowiska `test` wystarczy uruchomić `./recreate_database_test.sh`

### Testy
Po zainstalowaniu paczek przez composer'a należy uruchomić komendę `./vendor/bin/phpunit`

### Do serwowania zalecam Nginx + FPM, aczkolwiek paczka **Symfony Local Web Server** również powinna dać radę

### Mapowanie
|Entity|Route|Service|
| --- | --- | --- |
| XML | YAML | YAML |
