<h1>Дипломный проект на Symfony framework</h1>

Предполагаемый стек технологий:
<ul>
<li>Docker</li>
<li>Nginx</li>
<li>PHP 8.4 (Symfony 7 framework)</li>
<li>PostgreSQL 15</li>
<li>RabbitMQ</li>
<li>PhpUnit</li>
</ul>

<h3>Для запуска парсера товаров в каталог необходимо:</h3>
<ol>
<li>Поднять докер</li>
<li>Убедиться, что Supervisor поднялся и работоспособен (Если запускаем асинхронно)</li>
<li>Выполнить внутри контейнера (make bash) следующие команды:
    <ul>
        <li>bin/console product:create:debug (Для ручного запуска парсера)</li>
        <li>bin/console product:create (Для отправки сообщения в шину Messenger`а. Для cron и тд)</li>
    </ul>
</li>
</ol>  

