# PHP URL Shortener

This is a small, simplistic example of creating a URL shortener in PHP.

## Requirements

To use this application, you will need the following:

- [Docker Engine](https://docs.docker.com/engine/install/) and [Docker Compose](https://docs.docker.com/compose/install/) **or** PHP 8.1 with the [PDO](https://www.php.net/manual/en/pdo.installation.php) and [PDO_PGSQL](https://www.php.net/manual/en/ref.pdo-pgsql.php) extensions and [PostgreSQL](https://www.postgresql.org/) 14 or above.
- Your favourite IDE or code editor
- [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos) installed globally

## Usage

First, clone the project to a directory on your local machine by running the following command:

```bash
git clone git@github.com:settermjd/php-url-shortener.git php-url-shortener
```

Then, start the application. 
The two quickest ways to do so are: 

1. Use Docker Compose
1. Use PHP's built-in web server

Instructions for both are listed below.

### Using Docker Compose

To start the application, run the following command in the top-level directory of the project.

```bash
docker compose up -d --build
```

**Note:** The first time that you run the command, if you don't have one or more images in your local Docker cache, then they have to be downloaded. 
This shouldn't take too long, allowing for the speed of your internet connection.

**New to Docker Compose and want a hand getting started?** 
Then grab a copy of my free book: [Deploy with Docker Compose](https://deploywithdockercompose.com/).

### Using PHP's built-in webserver

To start the application, run the following command in the top-level directory of the project.

```bash
php -S 0.0.0.0:8080 -t public
```

## Have Questions?

If you have any questions or queries, either create [an issue](https://github.com/settermjd/php-url-shortener/issues/new/choose) or a PR, or email me: matthew[at]matthewsetter.com.