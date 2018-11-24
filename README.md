# Laravel Package for Google reCAPTCHA V3

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

Google reCAPTCHA v3 is a new mechanism to verify whether the user is bot or not.

## Features

- Score Comparision
- Support multiple input field for different <form> tag
- Support custom implementation on config interface
- Support custom implementation on request method interface 

## Requirement

This package requires the following dependencies:

- Laravel 5.x

- php > 5

- Please ensure that you have read basic information from Google reCAPTCHA v3.

## Installation


Via Composer

``` sh
$ composer require ryandeng/googlerecaptcha "^0.1.3"
```

If your Laravel framework version <= 5.4, please register the service provider in your config file: /config/app.php, otherwise please go to step 3.

```
RyanDeng\GoogleReCaptcha\Providers\GoogleReCaptchaV3ServiceProvider::class
```

If your Laravel framework version is >= 5.5, just run the following command to publish views and config.
```sh 
$ php artisan vendor:publish --provider="RyanDeng\GoogleReCaptcha\Providers\GoogleReCaptchaV3ServiceProvider"
```

After installation, you should see a googlerecaptcha/googlerecaptchav3.blade file in your views folder and googlerecaptchav3.php in your app/config folder.

If you want to change the default template, please check Advanced Usage.


## Basic Usage
#### Setting up your Google reCAPTCHA details in config file

Please register all details on host_name, site_key, secret_key and site_verify_url.

Specify your Score threshold and action in 'setting', e.g.

        [
            'action' => 'contact_us', // Google reCAPTCHA required paramater
            'id' => 'contactus_id', // your HTML input field id
            'threshold' => 0.2, // score threshold
            'is_enabled' => false // if this is true, the system will do score comparsion against your threshold for the action
        ]
        
Note: if you want to enable Score Comparision, you also need to enable is_score_enabled to be true.

Remember to turn on the service by enable is_service_enabled to be true.

For more details please check comments in config file. 
        
        {!!  \RyanDeng\GoogleReCaptcha\Facades\GoogleReCaptchaV3::render($action1,$action2) !!}
        
        <form method="POST" action="/verify1">
            @csrf
            <input type="hidden" id="your_id_1" name="g-recaptcha-response">
            <input type="submit" class="g-recaptcha" value="submit">
        </form>
        
        <form method="POST" action="/verify2">
                    @csrf
                    <input type="hidden" id="your_id_2" name="g-recaptcha-response">
                    <input type="submit" class="g-recaptcha" value="submit">
        </form>
                
-   You can pass multiple $action in render(...)     
-   Please specify your id for the input below:

``` html
    <input type="hidden" id="your_id" name="g-recaptcha-response">
```
Note: all values should be registered in googlerecaptchav3 config file in 'setting' section

   
#### Validation Class
   
   You can use provided Validation object to verify your reCAPTCHA.
      
```
   use RyanDeng\GoogleReCaptcha\Validations\GoogleReCaptchaValidationRule
   $rule = [
            'g-recaptcha-response' => [new GoogleReCaptchaValidationRule('action_name',$ip)]
        ];
```

   'g-recaptcha-response' is the name of your input field, which is currently hard-coded.
   
   GoogleReCaptchaValidationRule($actionName, $ip) which accepts two optional parameters:
   -  $actionName: if its NULL, the package won't verify action with google response.
   
   -  $ip: request remote ip, this is Google reCAPTCHA parameter.
   

#### Facade Class


```
GoogleReCaptchaV3::setAction($action)->verifyResponse($response, $ip);
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

The package uses Curl to verify, if you want to use your own request method, You can create your own class and implement 
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
## Testing

This test file will be added in the next release.


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
