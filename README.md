<div>
  <!--
  <h1 align="center">
    StackUnderflow
  </h1>
  -->
  <p align="center">
    <b>Stack Underflow</b>
    </br>
    <span font-size="16px">A Q&A web application built for programmers.</span>
    <br />
  </p>
</div>

StackUnderflow is a Q&A application based on the popular StackOverflow for my final school project. It is build using
mainly Laravel and Vue.

# Development

## Getting Started

### Installing dependencies

#### Laravel Sail

Laravel Sail is a light-weight command-line interface for interacting with Laravel's default Docker development
environment.

To start using it, we need to install our composer dependencies first:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

#### NPM

Before continuing, we need to install our front-end dependencies:

```
sail npm install
```

### Running the project

#### .env file

You should first set up your .env file. We already have an example file, so you may just copy that into your own:

```bash
cp .env.example .env
```

#### Starting Laravel Sail

After everything is installed, we can now initialize sail by running the following command:

```bash
vendor/bin/sail up -d
```

#### Aliasing Sail

You may wish to set up a Bash alias instead of repeatedely typing `vendor/bin/sail` everytime you want to run a command.
You can do so with:

```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

or by manually adding the following to your `~/.bash_aliases`:

```bash
alias sail='bash vendor/bin/sail'
```

This way, instead of running `vendor/bin/sail up -d` you can just do `sail up -d`.

### Algolia

We use Algolia for search. To set it up, simply create an application on the Algolia website, get the app credentials
and set them in the .env file.

```dotenv
ALGOLIA_APP_ID=
ALGOLIA_SECRET=
```

### Database

#### Database Migrations

Database Migrations are like a form of version control for databases. They allow you to easily upgrade to the latest
version a database without having to do it manually. This is seen especially useful when working as a team or when
setting up the project again.

To generate our migrations you may run the following command:

```bash
sail artisan migrate
```

You may also wish to seed the development database in order to have some dummy test data. You can do so with:

```bash
sail artisan db:seed
```

The only thing left to access the website is to add the record `127.0.0.1 stackunderflow.test` to your hosts file.
