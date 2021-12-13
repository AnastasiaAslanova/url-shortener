<h1><p align="center">URL SHORTENER</p></h1>
<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

### About Shortener

The purpose of this application is to provide shortened URLs for links.

###It provides the following features:
- Shortened URL
- Shortened URL with a key, for greater reliability.
- Named shortened links.

Redirect to original url when requesting a short url


It is possible to monitor the statistics of clicks on short links by month.

### Installation:
Execute in terminal:
```sh
git clone
```

- Create a file
.env at the root of the project.
- Copy the code from the .env.example file into it. 
- Then fill it in with your details.

```sh
$ cp .env.exampl .env
```
###If you have a sail alias execute:

```sh
sail up -d
```
```sh
sail composer install
```
```sh
sail composer install
```
Launching migrations
```sh
sail artisan migrate
```
Go to http://localhost/


###If there is no alias:
```sh
docker compose up -d
```
```sh
docker compose exec <servis name> composer install 
```
Launching migrations
```sh
php artisan migrate
```
Go to http://localhost/

###Statistic
The project has a console command HendleStatistic. By it's execution the statistic of previous day handled.
To run it, create a crown task.
```sh
0 3 * * * <you task>
```




