# pmi-admin


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


## Usage
Write a few lines about the usage of this package.


## Testing
Run the tests with:

``` bash
vendor/bin/phpunit
```
