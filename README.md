# StackUnderflow

StackUnderflow is a Q&A web application based on StackOverflow built using Laravel and Vue for my final course project
for school.

# Getting Started

This repository contains the PHP application code for StackUnderflow. This application uses the laravel/framework hence
laravel/laravel can be treated as an upstream of sorts. Before working on the application it is recommended to fully
read this document and to refer back to and edit throughout development.

# Deploying

# Local Development

## Provisioning

We use Laravel Sail for local development.

We need to install our composer dependencies in order to run Sail:

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php80-composer:latest \
    composer install --ignore-platform-reqs
```

### Starting sail

```
vendor/bin/sail up -d
```

The only thing left is to add `127.0.0.1 stackunderflow.test` to your hosts file.

### Aliasing Sail

Add the following to `~/.bashrc`

```
alias sail='bash vendor/bin/sail'
```

## Dependencies

Dependencies are automatically handled by Composer, a list of dependencies can be found in `composer.json`. To install
the current dependencies for a project run `sail composer install`.

If you wish to update the version of specific dependencies, make your change to `composer.json`, run `composer update`
and then commit your changes to `composer.json` and `composer.lock`.

## Database Seeding

You can seed a development database by simply running: `sail artisan db:seed`.

## Database Migrations

Database migrations are stored in `database/migrations`, this is a version control for the schema. You can generate new
migrations using the following command: `sail artisan make:migration create_users_table`.

## Asset Management

We use Laravel Mix for asset management, you can rtfm here: https://laravel.com/docs/8.x

## Using an IDE

If you wish to use an IDE, [Jetbrains PHPStorm](https://www.jetbrains.com/phpstorm) is the supported IDE for
StackUnderflow. It is strongly recommended to use
the [Laravel Plugin](https://plugins.jetbrains.com/plugin/7532-laravel-plugin).

The `_ide_helper.php` file is auto generated using the command `artisan ide-helper:generate` - this provides the IDE
with vastly improved PHPDocs of the Laravel framework. Select `no` when asked to generate model docblocks.

## Import an existing database in Sail

Put the stackunderflow.bak file in your project folder.

Exec into the Sail docker container:

```
sail shell
```

Import the backup:

```
PGPASSWORD=secret psql --host=pgsql --username=root --dbname=stackunderflow -c 'DROP SCHEMA public CASCADE;' && \
PGPASSWORD=secret psql --host=pgsql --username=root --dbname=stackunderflow -c 'CREATE SCHEMA public;' && \
PGPASSWORD=secret pg_restore -Fc stackunderflow.bak --dbname=stackunderflow --username=root --role=root --host=pgsql -j 10
```

Re-assign the roles:

```
PGPASSWORD=secret psql --host=pgsql --username=root --dbname=stackunderflow -c 'REASSIGN OWNED BY stackunderflow TO root;'
```

Done.
