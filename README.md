# QueryBuilder

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/MisterIcy/query-builder/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/MisterIcy/query-builder/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/MisterIcy/query-builder/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/MisterIcy/query-builder/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/MisterIcy/query-builder/badges/build.png?b=main)](https://scrutinizer-ci.com/g/MisterIcy/query-builder/build-status/main) 
[![QueryBuilder Checks](https://github.com/MisterIcy/query-builder/actions/workflows/ci.yaml/badge.svg)](https://github.com/MisterIcy/query-builder/actions/workflows/ci.yaml) 
[![codecov](https://codecov.io/gh/MisterIcy/query-builder/branch/main/graph/badge.svg?token=4WVEMKNJUO)](https://codecov.io/gh/MisterIcy/query-builder)

SQL Query Crafter for MySQL/MariaDB

## History

I no longer remember how many times I had to hand-craft and optimize a query for a particular case 
in various PHP projects. In order to perform the aforementioned optimizations, I had to resort to bad practices,
ugly code and extreme string manipulation. Until I said _no more_.

## Installation

Install the library with composer:

```shell
composer require mistericy/query-builder
```

## Usage

Create a new QueryBuilder object and start adding expressions:

```php
$queryBuilder = new QueryBuilder();
$queryBuilder->select(['id' => 'id', 'login' => 'username'])
    ->from('users', 'u');

$query = $queryBuilder->getQuery();
```

