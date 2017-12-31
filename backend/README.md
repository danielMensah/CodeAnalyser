# Code Checker (Backend)

Created with PHP 7 and Slim 3 Framework.

## Setup the environment

First thing, make sure to install [composer](https://getcomposer.org/download/) on your device. 
Composer is a dependency manager for PHP, just like Maven for Java or NPM for JavaScript. 
Composer will be used to run and test the application as well as installing needed dependencies.

If you don't have a PHP configuration folder on your device, download [XAMPP](https://www.apachefriends.org/index.html)
XAMPP which help you to manage your devices PHP configurations.

**Ensure to have installed PHP 7**

### Commands

Running the application

    composer start
   
Once the application is running, browse `http://localhost:8080/yourName`

Testing the application

    `composer test`

## What you need to know

**Backend Structure**

```angular2html
Backend
├───Controllers
├───logs
├───Models
├───public
│   └───.htaccess
│   └───index.php
├───src
│   └───dependencies.php
│   └───middleware.php
│   └───routes.php
│   └───settings.php
├───templates
├───tests
│   └───ControllersTest
│   └───Functional
├───vendor
├───composer.json
├───phpunit.xml
└───README.md
```

The `routes.php` file contains all API routes to the application. This will be the entry point for when the
front-end requests information from the backend. This is how you create an API route with Slim:

**Route with parameter**

```php
$app->get('/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});
```

**Route without parameter**

```php
$app->get('/displayMessage', function (Request $request, Response $response) {
    $response->getBody()->write("Hello World!");

    return $response;
});
```

### Documentations

[Slim 3 Framework](https://www.slimframework.com/docs/)

[PHP 7](http://php.net/docs.php)

