# Development

This document describes the process for running this application on your local computer.

## Table of Contents

[Getting Started](#getting-started)

[Running the project](#running-the-project)

[Database](#database)

## Getting started

Stack Underflow is powered by [Laravel](https://laravel.com/), [Vue.js 2](https://v2.vuejs.org/) and [Inertia](https://inertiajs.com/). You it highly recommended that you read their respective documentation before proceeding to make changes to this project.

### Requirements

* Docker

### Installing dependencies

We need to install our dependencies first before running the project.

#### Composer

This project uses Laravel Sail, a command-line interface for interacting with Laravel's Docker development environment.

To start using it, we need to install our composer dependencies (including Sail) first:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

You may wish to setup a Bash alias for sail using:

```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

or by manually adding the following to your `~/.bash_aliases`:

```bash
alias sail='bash vendor/bin/sail'
```

This makes it so you can run sail commands by typing `sail` instead of `vendor/bin/sail`.

#### NPM

Now we need to install our front-end dependencies:

```bash
npm install
```

## Running the project

With our dependencies installed, we just need to create a .env file to store our environment variables before we can run the project.

We have an example file, so you can copy that into your own:

```bash
cp .env.example .env
```

We can now initialize sail with the following command:

```bash
sail up -d
```

Finally, don't forget to generate a new app key:

```bash
sail artisan key:generate
```

### Algolia

We use [Algolia](https://www.algolia.com/) for search. After setting up an application through the Algolia website, get the app credentials and set them on the .env file:

```dotenv
ALGOLIA_APP_ID=
ALGOLIA_SECRET=
```

#### Importing into Algolia

When you save or update a model, the data is synchronized automatically (unless you're using mass assignment methods).

However, if you imported a database or already had existing data before setting up Algolia, you may wish to import the records manually. You can easily do so with:

```bash
sail artisan scout:import
```

## Database

### Migrations

To initialize our database, we need to run our migrations. You can do so with:

```bash
sail artisan migrate
```

You may also wish to seed the development database in order to have some dummy test data. You can do so with:

```bash
sail artisan db:seed
```

> **Warning**
> Before seeding, you must fill in the pusher env keys on your .env file. This is temporary.

The only thing left to access the website is to add the record `127.0.0.1 stackunderflow.test` to your hosts file.

## Assets

You may notice that some assets aren't working correctly. This is because we still have to link our `public/storage` folder to `storage/app/public`. This is easy:

```bash
sail artisan storage:link
```
