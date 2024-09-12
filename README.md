# Modular Laravel App

An example laravel app that uses Modules in laravel to help manage larger laravel codebases

This project only has one dependency `docker`. So make sure you have this installed first

## Setup

Run this script from the root directory of the repo:
```
./setup
```


## Tests

```
docker compose run --rm artisan test
```

## Linters
```
docker compose run --rm composer run rector
```
```
docker compose run --rm composer run pint
```
```
docker compose run --rm composer run phpstan
```
