* Funny how things just seemed so easy. (c) "The Cranberries - When We Were Young"

———————————
# Установка
```
composer require vestnik/modvert2:dev-develop
```
# Использование
##### Создать слепок
```
bin/modvert.cli.php dump
```

##### Построить из слепка
```
bin/modvert.cli.php build
```

##### Создание слепка из удаленного stage
```
bin/modvert.cli.php load-remote --stage=staging
or
bin/modvert.cli.php load-remote --stage=test
```
