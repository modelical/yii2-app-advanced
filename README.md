Yii 2 Advanced Project Template
===============================

Yii 2 Advanced Project Template with REST API is a skeleton [Yii 2](http://www.yiiframework.com/) 
application best for developing complex Web applications with multiple tiers.

The template includes four tiers: api, front end, back end, and console,
each of which is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Quick initialization:

```
yii migrate

yii migrate --migrationPath=@vendor/alegz/yii2-oauth2-server/migrations

init --env=Development --overwrite=all --baseurl=yii-app-advanced --dbpass=your-password
```

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii2-app-advanced/v/stable.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii2-app-advanced/downloads.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-advanced)

DIRECTORY STRUCTURE
-------------------

```
api
    components/          contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains api controller classes
    models/              contains api-specific model classes
    modules/             contains api-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for api application    
    web/                 contains the entry script and Web resources
common
    config/              contains shared configurations
    generators/          contains custom Gii generators
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
