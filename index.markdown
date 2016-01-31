---
layout: default
title:  "Welcome to Modvert2!"
date:   2016-01-29 23:08:21 +0300
categories: jekyll update
---

{{ site.posts }}

*{{ site.tag_text }}*

[![Build
Status](https://travis-ci.org/JasperGrimm/modvert2.svg?branch=develop)](https://travis-ci.org/JasperGrimm/modvert2)


#### Установка
{% highlight bash %}
composer require vestnik/modvert2:dev-develop
{% endhighlight %}
{% highlight bash %}
cp vendor/vestnik/modvert2/modvert.yml .
{% endhighlight %}

Файл modvert.yml должен выглядеть так:
{% highlight yaml %}
bootstrap: ""
database:
  host: "localhost"
  port: 33060
  user: "user"
  password: "sercret"
  name: "your_real_database"
  prefix: "qst_"

  test:
    host: "localhost"
    port: 3306
    user: "travis"
    password: ""
    name: "your_test_database"
    prefix: "qst_"

default_stage: 'test'
stages:
    staging:
        remote_url: 'http://staging.example.com/vendor/vestnik/modvert2/bin/modvert.web.php'
    test:
        remote_url: 'http://test.example.com/vendor/vestnik/modvert2/bin/modvert.web.php'
    development:
        remote_url: 'http://modvert.loc/vendor/vestnik/modvert2/bin/modvert.web.php'
{% endhighlight %}
#### Использование

<b>Примеры работы с реальным сайтом можно посмотреть <a href="tutorial.html">здесь</a></b>

##### Слить локальную БД в файлы
{% highlight bash %}
bin/modvert.cli.php dump
{% endhighlight %}

##### Построить из слепка
{% highlight bash %}
bin/modvert.cli.php build
{% endhighlight %}

##### Создание слепка из удаленного stage
Загрузка из <a href="http://staging.example.com">http://staging.example.com</a>
{% highlight bash %}
bin/modvert.cli.php load-remote --stage=staging
{% endhighlight %}

Загрузка из <a href="http://test.example.com">http://test.example.com</a>
{% highlight bash %}
bin/modvert.cli.php load-remote --stage=test
{% endhighlight %}


##### Ошибки
<table>
	<thead>
		<tr>
			<th>Сообщение</th>
			<th>Значение</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><span style="color:red">Remote stage is locked. Please try again!</span></td>
			<td>
				<p>
					Возникает при выполнении команды {% highlight bash %}bin/modvert.cli.php load-remote{% endhighlight %} На удаленном stage кто-то еще правит ресурс. Необходимо дождаться завершение редактирования, чтобы загрузить стабильную последнюю версию ресурса	
				</p>
			</td>
		</tr>
		<tr>
			<td><span style="color:red">Local stage is locked. Please try again!</span></td>
			<td>
				<p>
					Возникает при выполнении команды {% highlight bash %}bin/modvert.cli.php build{% endhighlight %} На локальном сервере есть редактируемые ресурсы. Воизбежание потери наработок, убедитесь, что весь контент корректно загружен в файлы. Если вы не редактируете более никакие ресурсы в manager, удалите блокировки и повторите операцию.
				</p>
			</td>
		</tr>
	</tbody>
</table>