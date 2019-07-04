# pmi-admin

This package provides API authentication service for both back end and mobile app users

## Getting Started

### Prerequisites
* Laravel
```sh
composer create-project --prefer-dist laravel/laravel pmijkt
```
* Laravel Passport
```sh
composer require laravel/passport
php artisan migrate
php artisan passport:install
```


## Install
To include the private Bitbucket repository via Composer you need to add this lines into your composer.json:

```json

    "repositories": [
      {
        "type": "vcs",
        "url" : "git@bitbucket.org:bajak_laut_malaka/pmi-admin.git"
      },
    ]
```

Add the package with:

```bash
composer require bajaklautmalaka/pmi-admin
```

Again, migrate all database tables necessary for this package
```sh
php artisan migrate
```

## Usage
### admin authentication
get auth token : using API testing tools (Postman, for example), make a POST request to /api/admin/login with `request headers` as follows:
```sh
Accept:application/json
Content-type:application/json
```
and request body below :
```json

	{
		"email": "admin@mail.com",
		"password": "Open1234"
	}
```
response should be 
logout


## Testing
Run the tests with:

``` bash
vendor/bin/phpunit
```
