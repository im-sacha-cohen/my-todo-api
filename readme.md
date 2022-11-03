# Todo & Co

##### Todo & Co is the 8th project of OpenClassrooms back-end course.
#
#
#
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/a60ba1ec3ac342e4a26075951167a43f)](https://www.codacy.com/gh/ThatsSacha/BileMo/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ThatsSacha/BileMo&amp;utm_campaign=Badge_Grade)

### Tech

Todo & Co uses technologies below :

- PHP with Symfony & MySQL

## Installation

Todo & Co requires [PHP](https://php.net) 8.0.1 to run.

You have to create a _.env_ file in current folder with your parameters
```sh
APP_ENV=dev
APP_SECRET=20bfad20186829f03dbfb047c621fc75

DATABASE_URL="mysql://root:password@127.0.0.1:3306/todo-and-co?serverVersion=5.7"

MAILER_DSN=smtp://user%password@shost:465
```
You should start a MySQL server to let the next setps working.

Then, in a terminal in the project folder
```sh
composer install -n && php bin/console make:db && symfony serve
```
The _"php bin/console make:db"_ script command will drop the database (if exists), create a new one, update the schema and load the fixtures.

You can now request _Todo & Co_ locally on http://localhost:[port]

You can use the default user credentials :
- email : user@todo.fr
- password : a