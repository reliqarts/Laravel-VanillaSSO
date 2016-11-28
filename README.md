# Laravel-VanillaSSO 

This package allows you to use jsConnect of Vanilla Forums in your Laravel 5 application and is a fork of [pdefreitas/vanillasso](https://github.com/pdefreitas/Laravel-VanillaSSO).

[![Built For Laravel](https://img.shields.io/badge/built%20for-laravel-red.svg?style=flat-square)](http://laravel.com)
![Build Status](https://img.shields.io/circleci/project/reliqarts/laravel-vanilla-sso.svg?style=flat-square)
[![StyleCI](https://styleci.io/repos/74924621/shield?branch=master)](https://styleci.io/repos/74924621)
[![License](https://poser.pugx.org/reliqarts/vanillasso/license?format=flat-square)](https://packagist.org/packages/reliqarts/vanillasso)
[![Latest Stable Version](https://poser.pugx.org/reliqarts/vanillasso/version?format=flat-square)](https://packagist.org/packages/reliqarts/vanillasso)
[![Latest Unstable Version](https://poser.pugx.org/reliqarts/vanillasso/v/unstable?format=flat-square)](//packagist.org/packages/reliqarts/vanillasso)

&nbsp;

SSO (Single Sign-on) will save your time if you want to implement a forum on your Laravel 5 application.

The package is availabe on Packagist https://packagist.org/packages/reliqarts/vanillasso

## Installation

1. Install via composer; in console: 
    ```
    composer require reliqarts/guided-image
    ``` 
    or require in *composer.json*:
    ```js
    {
        "require": {
            "reliqarts/vanillasso": "dev-master"
        }
    }
    ```
    then run `composer update` in your terminal to pull it in.

2. Edit the providers array in app.php (app/config/app.php)

    ```php
    'providers' => [
        // ...
        'ReliQArts\VanillaSSO\VanillaSSOServiceProvider',
        // ...
    ],
    ```

3. Publish the vanillasso.php config file to make it accessible in app/config/packages/reliqarts/vanillasso/vanillasso.php

    ```
     php artisan config:publish reliqarts/vanillasso
    ```

### Routes

An endpoint is automatically set based on your config. Default endpoint is: `login/forum`.

### Configuration

You can directly edit config\vanillasso.php or add it to your application.

The configuration file looks like this:
```php
return [
    // The string client ID that you set up in the jsConnect settings page.
    "client_id" => "",

    // The string secred that you set up in the jsConnect settings page.
    "secret" => "",

    // Endpoint
    "endpoint" => "",

    // User profile pic url.
    "profile_pic_url" => "http://mysite.dev/profile/pic/{user_id}",

    // Route related options.
    'routes' => [
        // Set the bindings for vanillasso
        'bindings' => [
            'middleware' => [
                'web',
                'auth',
            ]
        ]
    ],
];
```

Please note that this plugin supports MD5 and SHA1 hashes from JSconnect.

## License

Check LICENSE for more information.

## Credits

I want to thank Todd Burry from Vanilla Forums. This file helped producing this package:
https://github.com/vanilla/jsConnectPHP/blob/master/functions.jsconnect.php

## Trouble

If you use Vanilla 2.1 there is an annoying bug that you have to alter a table in order to jsConnect 1.4.1 be supported:
```sql
ALTER TABLE GDN_UserAuthenticationProvider ADD IsDefault BOOLEAN NOT NULL DEFAULT FALSE;
```
