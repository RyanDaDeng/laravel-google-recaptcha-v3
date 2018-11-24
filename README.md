# Laravel Package for Google reCAPTCHA V3

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]


Google reCAPTCHA v3 is a new mechanism to verify whether the user is bot or not.

## Features

- Score Comparision
- Support custom implementation on config interface
- Support custom implementation on request method interface 

## Requirement

This package requires the following dependencies:

- Laravel 5.x 

- If you want to use Validation Class your Laravel version needs to be >= 5.5

- php > 5

- Please ensure that you have read basic information from Google reCAPTCHA v3.

## Installation


Via Composer

``` sh
$ composer require ryandeng/googlerecaptcha "^0.2.0"
```

If your Laravel framework version <= 5.4, please register the service provider in your config file: /config/app.php, otherwise please skip it.


``` php
'providers'=[
    ....,
    RyanDeng\GoogleReCaptcha\Providers\GoogleReCaptchaV3ServiceProvider::class
]
```

And also
``` php
'aliases'=[
     ....,
     'GoogleReCaptchaV3'=>\RyanDeng\GoogleReCaptcha\Facades\GoogleReCaptchaV3::class
 ]
```


If your Laravel framework version is >= 5.5, just run the following command to publish views and config.
```sh 
$ php artisan vendor:publish --provider="RyanDeng\GoogleReCaptcha\Providers\GoogleReCaptchaV3ServiceProvider"
```

After installation, you should see a googlerecaptchav3/field.blade and header.blade file in your views folder and googlerecaptchav3.php in your app/config folder.

## Basic Usage
#### Setting up your Google reCAPTCHA details in config file

Please register all details on host_name, site_key, secret_key and site_verify_url.

Specify your Score threshold and action in 'setting', e.g.
``` php
      'setting' =  [
            'action' => 'contact_us', // Google reCAPTCHA required paramater
            'threshold' => 0.2, // score threshold
            'is_enabled' => false // if this is true, the system will do score comparsion against your threshold for the action
        ]
```        
Note: if you want to enable Score Comparision, you also need to enable is_score_enabled to be true.
``` php
'is_score_enabled' = true
```   

For more details please check comments in config file.

#### Display reCAPTCHA v3

Include Google API in header

``` html  
{!!  GoogleReCaptchaV3::requireJs() !!}
```

Include input field

``` PHP  
 {!!  GoogleReCaptchaV3::render($actionName, $fieldName) !!} // $actionName is your google action, $fieldName is optional for input field name
```

Example Usage

``` html  
{!!  GoogleReCaptchaV3::requireJs() !!}

<form method="POST" action="/verify">
    @csrf
    <input type="hidden" id="contactus_id" name="g-recaptcha-response">
    {!!  GoogleReCaptchaV3::render('contact_us') !!}

    <input type="submit" class="g-recaptcha" value="submit">
</form>

```

Note: all actions should be registered in googlerecaptchav3 config file in 'setting' section. 

You can also customise your own template under googlerecaptchav3 folder.
   
#### Validation Class (Only support Laravel >= 5.5)
   
   You can use provided Validation object to verify your reCAPTCHA.
      
``` php
   use RyanDeng\GoogleReCaptcha\Validations\GoogleReCaptchaValidationRule
   $rule = [
            'g-recaptcha-response' => [new GoogleReCaptchaValidationRule('action_name')]
        ];
```

   'g-recaptcha-response' is the name of your input field, which is currently hard-coded.
   
   GoogleReCaptchaValidationRule($actionName, $ip) which accepts two optional parameters:
   -  $actionName: if its NULL, the package won't verify action with google response.
   
#### Facade Class


``` php
GoogleReCaptchaV3::setAction($action)->verifyResponse($response);
```

$action: Google reCAPTCHA definition

$response: which is a value comes from g-recaptcha-response

$ip: optional

## Advanced Usage

#### Custom implementation on Config
    
For some users, they might store the config details in their own storage e.g database. You can create your own class and implement:

```
RyanDeng\GoogleReCaptcha\Interfaces\ReCaptchaConfigV3Interface
```

Remember to register your implementation, e.g.

``` php
     $this->app->bind(
                ReCaptchaConfigV3Interface::class,
                YourOwnCustomImplementation::class
            );
```

#### Custom implementation on Request method

The package uses Guzzle\Http to verify, if you want to use your own request method, You can create your own class and implement 
```
RyanDeng\GoogleReCaptcha\Interfaces\RequestClientInterface
```

Remember to register your implementation.
``` php
     $this->app->bind(
                RequestClientInterface::class,
                YourOwnCustomImplementation::class
            );
```

## Security

If you discover any security related issues, please email ryandadeng@gmail.com instead of using the issue tracker.


## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/ryandeng/googlerecaptcha.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ryandeng/googlerecaptcha.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/ryandeng/googlerecaptcha/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/ryandeng/googlerecaptcha
[link-downloads]: https://packagist.org/packages/ryandeng/googlerecaptcha
[link-author]: https://github.com/ryandadeng
