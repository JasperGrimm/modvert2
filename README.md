# Modvert2
*Modx sync and versioning tool*

[![Build
Status](https://travis-ci.org/JasperGrimm/modvert2.svg?branch=develop)](https://travis-ci.org/JasperGrimm/modvert2)


# Установка
```
composer require vestnik/modvert2:dev-develop
```
# Использование

<iframe width="560" height="315" src="https://www.youtube.com/embed/wcWMQHCiMTQ" frameborder="0" allowfullscreen></iframe>

###### Пример работы с фич-ветками.
<iframe width="560" height="315" src="https://www.youtube.com/embed/cd-owDfxkqo" frameborder="0" allowfullscreen></iframe>

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

##### Ошибки
Сообщение|Значение
--- | ---
Remote stage is locked. Please try again!|Возникает при выполнении команды ```bin/modvert.cli.php load-remote``` На удаленном stage кто-то еще правит ресурс. Необходимо дождаться завершение редактирования, чтобы загрузить стабильную последнюю версию ресурса
Local stage is locked. Please try again!|Возникает при выполнении команды ```bin/modvert.cli.php build``` На локальном сервере есть редактируемые ресурсы. Воизбежание потери наработок, убедитесь, что весь контент корректно загружен в файлы. Если вы не редактируете более никакие ресурсы в manager, удалите блокировки и повторите операцию.
