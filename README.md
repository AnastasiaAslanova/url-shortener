<h1><p align="center">URL SHORTENER</p></h1>
<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

### About Shortener

The purpose of this application is to provide shortened URLs for links.

### It provides the following features:
- Shortened URL
- Shortened URL with a key, for greater reliability.
- Named shortened links.

Redirect to original url when requesting a short url


It is possible to monitor the statistics of clicks on short links by month.

### Installation:
Execute in terminal:
```sh
git clone
cd url-shortener
```

If the composer is installed on a local computer:
```sh
composer install --ignore-platform-reqs
```
If not, run composer install from the docker container:
```sh
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php80-composer:latest \
    composer install --ignore-platform-reqs
```

- Create a file
.env at the root of the project.
- Copy the code from the .env.example file into it. 
- Then fill it in with your details.

```sh
cp .env.exampl .env
```

Generating keys
```sh
php artisan key:generate
```

To run a container:
```sh
./vendor/bin/sail build --no-cache
```
```sh
./vendor/bin/sail up -d
```
Launching migrations
```sh
./vendor/bin/sail artisan migrate
```
Go to http://localhost/

To use github auth - create github application, copy and paste github_client_id and github_client_secret to .env

### Statistic
The project has a console command HendleStatistic. By it's execution the statistic of previous day handled.
To run it, create a crown task.
```sh
0 3 * * * <you task>
```




