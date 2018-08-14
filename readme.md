
## Постман коллекция для тестирования

https://www.getpostman.com/collections/0413563d170fbad09196


## Соглашения и ограничения

Размерность счета ограничена int(21 474 836.47).
Числа указываются с разделителем - точка.
Внутри API и в БД суммы указываются в копейках. Т. е. 1.5 USD в системе хранится как 150 USD.
Валюта указывается в нижнем регистре и всегда в одном формате, например "rub", "eur".
При переводе между кошельками валюта перевода является валютой одного из кошельков.


## Описание технологий

Использованы технологии:
PHP 7.1
Laravel 5.6
Postgres

Тестирование с использованием
Postman
Chrome

В системе есть сущности User, Wallet, History, Rate. Им соответствуют таблицы в бд. В таблицу users добавлен индекс для уникальности пользователей. В history добавлен индекс для производительности. В history сохраняется сумма операции в usd по курсу на момент операции.

Бизнес-логика выделена в сервисы. Логика работы с данными инкапсулирована в репозиториях. Внедрение зависимостей выполнено через сервис-контейнер. Логирование при помощи Monolog.


## Что улучшить?

Валидация практически отсутствует
Обработка ошибок
Может индексы где добавить
Шардить таблицу истории операций по walletId
Выгружать файл в асинхроне через одноразовую ссылку
Добавить тесты, особенно на конвертацию и фин операции
Использовать redis, особенно для хранения курсов валют
Местами нарушены уровни абстракции, принцип единой ответственности, инверсии зависимости
Фронт улучшить поддержку на различных браузерах, добавить функционал в пагинацию,  добавить отступы между элементами


## Что хорошо?

Код выполняет поставленную задачу
Код написан относительно чисто
Местами соблюдён solid и др best practice
В основном приложение разделено по слоям
Код легко покрывается юнит-тестами, есть образец теста на CurrencyConverter
Код стайл стремится к psr-2
