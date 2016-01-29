---
layout: default
title:  "Welcome to Modvert2!"
date:   2016-01-29 23:08:21 +0300
categories: jekyll update
---

*Modx sync and versioning tool*

[![Build
Status](https://travis-ci.org/JasperGrimm/modvert2.svg?branch=develop)](https://travis-ci.org/JasperGrimm/modvert2)


#### Установка
{% highlight bash %}
composer require vestnik/modvert2:dev-develop
{% endhighlight %}

#### Использование

{% highlight bash %}
bin/modvert.cli.php dump
{% endhighlight %}

##### Построить из слепка
{% highlight bash %}
bin/modvert.cli.php build
{% endhighlight %}

##### Создание слепка из удаленного stage
{% highlight bash %}
bin/modvert.cli.php load-remote --stage=staging
{% endhighlight %}
{% highlight bash %}
bin/modvert.cli.php load-remote --stage=test
{% endhighlight %}

##### Ошибки
Сообщение|Значение
--- | ---
Remote stage is locked. Please try again!|Возникает при выполнении команды ```bin/modvert.cli.php load-remote``` На удаленном stage кто-то еще правит ресурс. Необходимо дождаться завершение редактирования, чтобы загрузить стабильную последнюю версию ресурса
Local stage is locked. Please try again!|Возникает при выполнении команды ```bin/modvert.cli.php build``` На локальном сервере есть редактируемые ресурсы. Воизбежание потери наработок, убедитесь, что весь контент корректно загружен в файлы. Если вы не редактируете более никакие ресурсы в manager, удалите блокировки и повторите операцию.
