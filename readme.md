# Todo & Co

##### Todo & Co is the 8th project of OpenClassrooms back-end course.

#
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/976dd49606ea4625a82910eb3b119757)](https://www.codacy.com/gh/im-sacha-cohen/my-todo-api/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=im-sacha-cohen/my-todo-api&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://app.codacy.com/project/badge/Coverage/976dd49606ea4625a82910eb3b119757)](https://www.codacy.com/gh/im-sacha-cohen/my-todo-api/dashboard?utm_source=github.com&utm_medium=referral&utm_content=im-sacha-cohen/my-todo-api&utm_campaign=Badge_Coverage)

### Tech

Todo & Co uses technologies below :

- PHP with Symfony & MySQL

## Installation

Todo & Co requires [PHP](https://php.net) 8.0.1 to run.

Then, in a terminal in the project folder
```sh
composer install -n
```

Next, you have to replace the _.env_ file variables below by your details
```sh
DATABASE_URL="mysql://root:password@127.0.0.1:3306/todo-and-co?serverVersion=5.7"

MAILER_DSN=smtp://user%password@shost:465
```

After, run in a terminal
```sh
php bin/console make:db
symfony serve
```
The _"php bin/console make:db"_ script command will drop the database (if exists), create a new one, update the schema and load the fixtures.

You should start a MySQL server to let the next setps working.

You can now request _Todo & Co_ locally on http://localhost:[port]

You can use the default user credentials :
- email : user@todo.fr
- password : a