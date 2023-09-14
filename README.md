# order-api

PROJECT SETUP

Welcome to the Code Assignment project! This repository contains the codebase for assessment

## Requirements

- PHP Version: 8.1.8
- Symfony Version: 6.3.4

## Getting Started

Follow these steps to get the project up and running on your local machine.

### Clone the Repository

git clone --branch master https://github.com/someswararaojagarapu/order-api.git

## Install Dependencies
Use Composer to install the required dependencies.

composer install

## Run Migration
symfony bin/console make:migration

symfony bin/console doctrine:migrations:migrate

## Load Fixtures Data

php bin/console doctrine:fixtures:load

## Start the Symfony Server
Launch the Symfony server to run the application.

symfony server:start


## Running PHPUnit Tests
PHPUnit is used for testing the application. Run the following command to execute the tests.

Please note Currently Unit tests are WIP

./vendor/bin/phpunit

## APIs
We can see all the APIs in Swagger

API URL: https://localhost:8000/api

https://localhost:8000/api/order

https://localhost:8000/api/order/{orderId}

https://localhost:8000/api/order?status=Completed

https://localhost:8000/api/order

## Console command
php bin/console order:update:status
