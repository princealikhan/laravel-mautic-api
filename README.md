## Mautic API in Laravel/Lumen.
Free and Open Source Marketing Automation API

## Requirements
* PHP 5.5.* or newer
* cURL support

## Mautic Setup
The API must be enabled in Mautic. Within Mautic, go to the Configuration page (located in the Settings menu) and under API Settings enable
Mautic's API.  You can also choose which OAuth2 protocol to use here.  After saving the configuration, go to the API Credentials page
(located in the Settings menu) and create a new client.  Enter the callback/redirect URI that the request will be sent from.  Click Apply
then copy the Client ID and Client Secret to the application that will be using the API.

## Installation

First, you'll need to require the package with Composer:
```sh
composer require princealikhan/laravel-mautic-api
```
Aftwards, run `composer update` from your command line.

Then, update `config/app.php` by adding an entry for the service provider.

```php
'providers' => [
	// ...
	'Princealikhan\Mautic\MauticServiceProvider',
],
```
Then, register class alias by adding an entry in aliases section
```php
'aliases' => [
    //.....
    'Mautic' => 'Princealikhan\Mautic\Facades\Mautic',
],
```
Finally, from the command line run `php artisan vendor:publish` to publish the default configuration file. 
This will publish a configuration file name `mautic.php` ,`consumer migration` and `consumer model`.

Run `php artisan migrate` migration command to create consumer table in your database. 

## Configuration
You need to add your `client id`, `client secret` and  `callback url`  in `mautic.php` file that is found in your applications `config` directory.

## Authorization
This Library only support OAuth2 Authorization
you must need to create a OAuth2 client in order to use api.

## Registering Application
In order to register you application with mautic ping this url this is one time registration.
```url
http://your-app/mautic/application/register
```


# Usage
Add Mautic Facade in your controller.
```php
use Mautic;
```
#### Send a request to mautic ( Example )
Create a new contact in mautic.
```php
$params = array(
    'firstname' => 'Prince',
    'lastname'=> 'Ali Khan',
    'email' => 'princealikhan08@gmail.com'
);

Mautic::request('POST','contacts/new',$params);
```
Get List of all contacts
```php
Mautic::request('GET','contacts');
```
Get a unique contact
```php
Mautic::request('GET','contacts/1');
//where 1 is unique id for a contact.
```

Delete a contact
```php
Mautic::request('Delete','contacts/1/delete');
```
##### And many more endpoints support by mautic.
### List of Endpoints supported by Mautic.

#### Contacts 
```json
[
    "contacts",
    "contacts/{id}",
    "contacts/list/fields",
    "contacts/list/owners",
    "contacts/new",
    "contacts/{id}/edit",
    "contacts/{id}/delete",
    "contacts/{id}/notes",
    "contacts/{id}/segments",
    "contacts/{id}/campaigns"
]
```

#### Assets 
```json
[
    "assets",
    "assets/{id}"
]
```

#### Campaigns 
```json
[
    "campaigns",
    "campaigns/{id}",
    "campaigns/contact/{id}/add/{leadId}",
    "campaigns/contact/{id}/remove/{leadId}"
]
```

#### Data 
```json
[
    "data",
    "data/{type}",
]
```
#### Emails 
```json
[
    "emails",
    "emails/{id}",
    "emails/{id}/send",
    "emails/{id}/send/lead/{leadId}"
]
```

#### Forms 
```json
[
    "forms",
    "forms/{id}"
]
```
#### Pages 
```json
[
    "pages",
    "pages/{id}"
]
```
#### Points 
```json
[
    "points",
    "points/{id}",
    "points/triggers",
    "points/triggers/{id}"
]
```
#### Reports 
```json
[
    "reports",
    "reports/{id}"
]
```
#### Segments 
```json
[
    "segments",
    "segments/contact/{id}/add/{leadId}",
    "segments/contact/{id}/remove/{leadId}"
]
```
#### Users 
```json
[
    "roles",
    "roles/{id}",
    "users",
    "users/{id}",
    "users/list/roles",
    "users/self",
    "users/{id}/permissioncheck",
]
```

Please refer to [Documentation](https://developer.mautic.org).
for all customizable parameters.
