# pmi-admin

This package provides API authentication service for both back end and mobile app users

## Getting Started

### Prerequisites
* [Laravel](https://laravel.com/docs)
```sh
composer create-project --prefer-dist laravel/laravel pmijkt
```
* [Laravel Passport](https://laravel.com/docs/5.5/passport)
```sh
composer require laravel/passport
php artisan migrate
php artisan passport:install
```
* [Guzzle HTTP Library](http://docs.guzzlephp.org/en/stable)
```sh
composer require guzzlehttp/guzzle
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
### Admin Authentication
#### Login
using API testing tools ([Postman](https://www.getpostman.com), for example), make a `POST` request to `/api/admin/login` with `request headers` as follows:
```sh
Accept:application/json
Content-type:application/json
```
Given a request body below :
```json

	{
		"email": "admin@mail.com",
		"password": "Open1234"
	}
```
then the valid response you're getting should be :
```json

	{
		"status": "success",
		"data": {
			"token": "<<auth token here>>"
		}
	}
```

#### Logout

### Response macros
#### [JSend](https://github.com/omniti-labs/jsend)
* Response type : **Success**
```php

	return response()->success(['category'=>'Blog']);
```
will render response:
```json

	{
		"status": "success",
		"data": {
			"category": "Blog"
		}
	}
```
* Response type : **Fail**
```php

	return response()->fail([
		"errors"=>[
			['name'=>'field name is required'],
			['email'=>'invalid email format']
		]
	]);
```
will render response:
```json

	{
		"status": "fail",
		"data": {
			"errors":[
				{"name": "field name is required"},
				{"email": "invalid email format"}
			]
		}
	}
```

## Testing
Run the tests with:

``` bash
vendor/bin/phpunit
```
