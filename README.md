# Phalcon API Boilerplate Project With OAuth2 Server

This repo contains a boilerplate project for a Phalcon API including an OAuth2 Server 
(https://github.com/thephpleague/oauth2-server) to manage authentication and authorization checks.

Currently support
* client_credentials grant (bearer)
* password grant (plain/bearer)
* token_refresh grant (plain/bearer)
* API requests validation (plain/bearer)
* Client scripts/sandbox for the supported grant

### ******************* Disclaimer *******************

This project is under construction
* Do not attempt to use in prod environment
* PM me for requests/suggestions

### ******************************************************


## Requirements

Before you install this project make sure your environment includes the following requirements:

* PHP 7.*
* Phalcon 3.*
* Module php_openssl activated

## Installation

### All environments

1) Clone or download the repo
2) Run `composer update` in the project folder
3) Create the `oauth2` database and import the content of the `config/dump-[prefered-charset].sql` file
4) *Coming soon: test token creation and API call using the client snippet* 

### Additional steps for production environment

1) Secure or remove the `public/docs` folder to prevent access to the sandbox

## Development

### Swagger documentation/sandbox

This repository include a Swagger documentation (http://swagger.io/) and a sandbox. You can launch it by double-clicking on the `index.html` file in 
the `docs/swagger` folder. 

#### Annotations

The Swagger documentation use doctrine annotations (http://doctrine-common.readthedocs.io/en/latest/reference/annotations.html).  

The annotations should look like this:
```php
/**
 * @SWG\Get(
 *     path="/api/resource.json",
 *     @SWG\Response(response="200", description="An example resource")
 * )
 */
``` 

You can find some annotation examples in the existing files :

`app/controllers/DefaultController.php` (Global annotations)  
`app/controllers/OAuth2/OAuth2AccessTokenController.php` (Call, request parameters and response annotations)  
`app/entities/models/AccessTokenModel.php` (Entity annotations)  


#### Generate/update documentation

To generate the Swagger documentation for the application (`app` folder) run the following command

```bash
php docs/swagger/generate.php
```

## Tests

### Examples

#### Custom sandbox

This sandbox contains working examples of a client implementation.

See the following files for more details:

`/docs/examples/client-client_credentials.php`
`/docs/examples/client-password.php`
`/docs/examples/client-refresh_token.php`