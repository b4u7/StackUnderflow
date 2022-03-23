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

Add the following to `~/.bash_aliases`

```
alias sail='bash vendor/bin/sail'
```

## Dependencies

Dependencies are automatically handled by Composer, a list of dependencies can be found in `composer.json`. To install
the current dependencies for a project run `sail composer install`.

If you wish to update the version of specific dependencies, make your change to `composer.json`, run `composer update`
and then commit your changes to `composer.json` and `composer.lock`.

## Database Migrations

Database migrations are stored in `database/migrations`, this is a version control for the schema. You can generate new
migrations using the following command: `sail artisan migrate`.

## Database Seeding

You can seed a development database by simply running: `sail artisan db:seed`.

## Asset Management

We use Laravel Mix for asset management, you can rtfm here: https://laravel.com/docs/8.x

## Using an IDE

If you wish to use an IDE, [Jetbrains PHPStorm](https://www.jetbrains.com/phpstorm) is the supported IDE for
StackUnderflow. We strongly recommended you to use the
[Laravel Plugin](https://plugins.jetbrains.com/plugin/7532-laravel-plugin).

The `_ide_helper.php` file is auto generated using the command `artisan ide-helper:generate` - this provides the IDE
with vastly improved PHPDocs of the Laravel framework. Select `no` when asked to generate model doc-blocks.
