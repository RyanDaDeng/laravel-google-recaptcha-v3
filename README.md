<!--
  Title: Laravel Recaptcha v3
  Description: Laravel recaptcha v3
  Author: ryandeng
  -->
  <meta name='keywords' content='recaptcha v3,laravel recaptcha v3,laravel google recaptcha v3,google recaptcha v3,laravel recaptcha,laravel recaptcha v3'>

# Laravel Package for Google reCAPTCHA V3
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Coverage Status][ico-coverage]][link-coverage]
[![Build][ico-build]][link-build]
[![StyleCI][ico-styleci]][link-styleci]

A star would be a nice encouragement. ^.^

## Latest features:

 - Refresh Ajax supported
 - Content security policy supported
 - Multi lang supported
 - Vue component supported
 - Background mode supported
 
If you want to use v2, please go to: https://github.com/RyanDaDeng/laravel-google-recaptcha-v2

If you only need to use Vue component, feel free to copy it.


# Table of Contents
1. [Installation](#installation)
2. [Configurations](#settings)
3. [Facade Usage](#facade-usage)
4. [Blade Usage](#blade-basic-usage)
5. [Ajax Usage](#ajax-usage)
6. [Vue Usage](#vue-usage)
7. [Validation](#validation-class)
8. [Advanced Usage](#advanced-usage)
9. [Contributors](#contributors)

*Demo code:* https://github.com/RyanDaDeng/laravel-google-recaptcha-v3/wiki/Simple-Demo


# DEMO

## Invisible - hidden

<img src="https://github.com/RyanDaDeng/aws-study-notes/blob/master/881545398213_.pic.jpg" width="250" height="300" />

## Inline

<img src="https://github.com/RyanDaDeng/aws-study-notes/blob/master/891545398531_.pic.jpg" width="250" height="300" />

## Corner

<img src="https://github.com/RyanDaDeng/aws-study-notes/blob/master/901545398593_.pic.jpg" width="150" height="100" />

## Description

Google reCAPTCHA v3 is a new mechanism to verify whether the user is bot or not.

reCAPTCHA v3 is intended for power users, site owners that want more data about their traffic, and for use cases in which it is not appropriate to show a challenge to the user.

For example, a registration page might still use reCAPTCHA v2 for a higher-friction challenge, whereas more common actions like sign-in, searches, comments, or voting might use reCAPTCHA v3.

Please check Google site: https://developers.google.com/recaptcha/docs/faq

## Features

- High Test coverage, safe and easy to use
- Score Comparision
- Support invisible, corner and inline badge style
- Support reCAPTCHA to run on every page
- Support multiple actions to be placed on the same page
- Support custom implementation on config interface
- Support custom implementation on request method interface
- Fully supported Vue component
- IP skip list supported

## Requirement

This package requires the following dependencies:

- Laravel >= 5.x

- If you want to use Validation Class your Laravel version needs to be >= 5.5

- php > 5

- Please ensure that you have read basic information from Google reCAPTCHA v3.

## Installation <a name="installation" />

*Demo code:* https://github.com/RyanDaDeng/laravel-google-recaptcha-v3/wiki/Simple-Demo


Via Composer

``` sh
        $ composer require timehunter/laravel-google-recaptcha-v3 "~2.5" -vvv
```

If your Laravel framework version <= 5.4, please register the service provider under your config file: /config/app.php, otherwise please skip it.


``` php
'providers'=[
    ....,
    TimeHunter\LaravelGoogleReCaptchaV3\Providers\GoogleReCaptchaV3ServiceProvider::class
]
```

And also
``` php
'aliases'=[
     ....,
     'GoogleReCaptchaV3'=> TimeHunter\LaravelGoogleReCaptchaV3\Facades\GoogleReCaptchaV3::class
 ]
```


If your Laravel framework version is >= 5.5, just run the following command to publish config.
```sh
$ php artisan vendor:publish --provider="TimeHunter\LaravelGoogleReCaptchaV3\Providers\GoogleReCaptchaV3ServiceProvider" --tag=googlerecaptchav3.config
```

For vue component:
```sh
$ php artisan vendor:publish --provider="TimeHunter\LaravelGoogleReCaptchaV3\Providers\GoogleReCaptchaV3ServiceProvider" --tag=googlerecaptchav3.vuejs
```

After installation, you should see a googlerecaptchav3.php in your app/config folder, and vue component under js/components/googlerecaptchav3 folder.


For multi lang:
```sh
$ php artisan vendor:publish --provider="TimeHunter\LaravelGoogleReCaptchaV3\Providers\GoogleReCaptchaV3ServiceProvider" --tag=googlerecaptchav3.lang
```
A lang folder will be created under /resources/lang/vendor/GoogleReCaptchaV3/*

## Configurations <a name="settings" />
### Setting up your Google reCAPTCHA details in config file

Please register all details in config for host_name, site_key, secret_key and site_verify_url.

Register credentials in .env:

````
RECAPTCHA_V3_SECRET_KEY=
RECAPTCHA_V3_SITE_KEY=
````

Specify your Score threshold and action in 'setting', e.g.
``` php
      'setting' =  [
          [
                'action' => 'contact_us', // Google reCAPTCHA required paramater
                'threshold' => 0.2, // score threshold
                'score_comparison' => false // if this is true, the system will do score comparsion against your threshold for the action
            ],
            [
                'action' => 'signup',
                'threshold' => 0.2,
                'score_comparison' => true
            ],
        ]


```
Note: if you want to enable Score Comparision, you also need to enable is_score_enabled to be true.
``` php

        ...
        'is_score_enabled' = true
        ...

```

For score comparision, all actions should be registered in googlerecaptchav3 config file under 'setting' section.

For more details please check comments in config file.



## Facade Usage <a name="facade-usage" />

You can directly use registered facade service by calling the following methods.

- setAction() is optional only if you want to verify if the action is matched.
- verifyResponse() which accepts the token value from your form. This returns Google reCAPTCHA Response object.
- setScore() is optional only if you want to manually verify the score.


Example Usage

``` php
   GoogleReCaptchaV3::setAction($action)->verifyResponse($value,$ip = null);
```

``` php
   GoogleReCaptchaV3::verifyResponse($value,$ip)->getMessage();
   GoogleReCaptchaV3::verifyResponse($value)->isSuccess();
   GoogleReCaptchaV3::verifyResponse($value)->toArray();
```


``` php
   GoogleReCaptchaV3::verifyResponse(
                         $request->input('g-recaptcha-response'),
                         $request->getClientIp()
                         )
                      ->getMessage()
```


``` php
   GoogleReCaptchaV3::setAction($action)->verifyResponse($value)->isSuccess();
 ```

If you manually assign a value to setScore($score), the code will fully skip your config file and force to check the score.

``` php
   GoogleReCaptchaV3::setScore($score)
                    ->setAction($action)
                    ->verifyResponse(
                        $request->input('g-recaptcha-response'),
                        $request->getClientIp()
                        )
                    ->getMessage()
```


## Validation Class (Only support Laravel >= 5.5) <a name="validation-class" />

   You can use provided Validation object to verify your reCAPTCHA.

``` php
   use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;
   $rule = [
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('action_name')]
        ];
```

   -  $actionName: if its NULL, the package won't verify action with google response.



## Blade Usage <a name="blade-basic-usage" />

### Display reCAPTCHA v3

#### Add Google API script

Include the API script at the bottom of your layout page

``` html
  {!!  GoogleReCaptchaV3::init() !!}
```
##### Consent Security Policy - Nonce

To add a nonce for content security, pass a params array with your pages nonce. 

``` html
  {!!  GoogleReCaptchaV3::init([
    'nonce' => nonce(),
  ]) !!}
```

#### Running script on every page (optional)

It's recommended to include reCAPTCHA v3 on every page which can help you get the most context about interactions for analytics. You just need to enable the config:

``` php
   ...
  'background_badge_display' => true, // if false, the badge will be invisible, if true the badge shows at bottom right.
  'background_mode' => false, // if true, the script will run on every page (ensure that GoogleReCaptchaV3::init() is placed on layout or homepage)
   ...
```
If the page has not detected any Action or duplicate google script, the background mode will be enabled.

#### Form & Action

There are three methods to populate the reCAPTCHA within the form.

- render() and renderOne() can be placed in anywhere but before init()
- renderField() needs always to be placed within your form.

Method one - render():

```
[
    $id=>$action , $id=>$action ...
]

{!!  GoogleReCaptchaV3::render(['contact_us_id'=>'contact_us', 'signup_id'=>'signup']) !!}
```

``` html
<form method="POST" action="/verify">
    <div id="contact_us_id"></div> // add div with id
    <input type="submit" value="submit">
</form>


<form method="POST" action="/verify">
    <div id="signup_id"></div>
    <input type="submit" value="submit">
</form>

{!!  GoogleReCaptchaV3::render(['contact_us_id'=>'contact_us', 'signup_id'=>'signup']) !!}

```

Method two - renderOne():

```
GoogleReCaptchaV3::renderOne($id,$action);

{!!  GoogleReCaptchaV3::renderOne('contact_us_id','contact_us') !!}
```

``` html
<form method="POST" action="/verify">
    <div id="contact_us_id"></div> // add div with id
    <input type="submit" value="submit">
</form>

{!!  GoogleReCaptchaV3::renderOne('contact_us_id','contact_us') !!}

```


Method three - renderField():

```
GoogleReCaptchaV3::renderField($id,$action,$class,$style)

{!! GoogleReCaptchaV3::renderField('contact_us_id','contact_us_action') !!}
```


``` html

<form method="POST" action="/verify">
   {!!  GoogleReCaptchaV3::renderField('contact_us_id','contact_us_action') !!}
    <input type="submit" value="submit">
</form>


```

### Badge Display for Form & Action

If your settings were not reflected, please run php artisan config:cache to clear cache.

Inline

1. Go to config file, and set
``` PHP
    [
        ...
        'inline' => true
        ...
    ]
```
2. Badge will be displayed as inline format within the form.


Invisible

1. Set inline as true as well
2. Modify your div with style display:none
3. Refer to Google official site: https://developers.google.com/recaptcha/docs/faq
, you need to include the following text:
 ``` HTML
    This site is protected by reCAPTCHA and the Google
        <a href="https://policies.google.com/privacy">Privacy Policy</a> and
        <a href="https://policies.google.com/terms">Terms of Service</a> apply.
 ```

Corner

1. Set inline as false
2. Your badge will be shown in the bottom right side.

Custom

1. Set inline as true
2. Do Styling/CSS on its div element

### Ajax Usage - Refresh reCAPTCHA Response <a name="ajax-usage" />

The package provides two handy Javascript functions for you to get recaptcha response and refresh recaptcha as needed.

- refreshReCaptchaV3(fieldId,actionName) - this function will reset the response whenever your ajax response is returned.

- getReCaptchaV3Response - this function helps you to get recaptcha response by id

For example:

````html
       <script>
            $("#test").click(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '/verify',
                    data: {
                        'g-recaptcha-response':getReCaptchaV3Response('contact_id')
                    },
                    success: function (data) {
                        refreshReCaptchaV3('contact_id','contact');
                    },
                    error: function(err){
                        refreshReCaptchaV3('contact_id','contact');
                    }
                });
            });
      </script>
````
## Vue Usage (Package version >= 2.2.0) <a name="vue-usage" />

The package provides a lightweight vue component. You need to publish the vue component before playing around it.

### Step 1 Publish vue component:
```sh
$ php artisan vendor:publish --provider="TimeHunter\LaravelGoogleReCaptchaV3\Providers\GoogleReCaptchaV3ServiceProvider" --tag=googlerecaptchav3.vuejs
```

The file will be created under js/components/googlerecaptchav3/GoogleReCaptchaV3.vue, you have full control and modification ability on this file.


### Step 2 Import vue component and Register reCAPTCHA v3 SiteKey

#### A BIG thanks to [@Fluxlicious](https://github.com/Fluxlicious) who improved the vue component.

The Blade way is no longer useful if you use Vue. We need to manage to assign site key by ourselves. The component supports props below:

Supported: siteKey, id, inline and action, check the original file to see the details.

````vue
<google-re-captcha-v3
  v-model="gRecaptchaResponse"
  ref="captcha"
  site-key="Your Site Key String Here"
  id="contact_us_id"
  inline
  action="contact_us"
></google-re-captcha-v3>

````


There are two ways you can bind site key to the component.

### Use prop

````vue
<template>
    <div>
        <form @submit.prevent="submit">
            <div>
                <google-re-captcha-v3
                  v-model="form.gRecaptchaResponse"
                  ref="captcha"
                  :site-key="mySiteKeyVariable"
                  id="contact_us_id"
                  inline
                  action="contact_us"
                ></google-re-captcha-v3>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</template>
<script>
    import GoogleReCaptchaV3 from '../../components/googlerecaptchav3/GoogleReCaptchaV3';
    // location might be diff to your case, ensure that your component location is right

    export default {
        components: {
            GoogleReCaptchaV3
        },
        data() {
            return {
                form: {
                    gRecaptchaResponse: null
                },
                mySiteKeyVariable: 'Your Site Key String',
            }
        },
        methods: {
            submit() {
                axios.post('/verify', this.form).then(
                    response => {
                        this.$refs.captcha.execute(); // every time you submit, the reCAPTCHA token needs to be refreshed
                    }
                ).catch(
                    error => {
                        this.$refs.captcha.execute(); // every time you submit, the reCAPTCHA token needs to be refreshed
                    });
            }
        }
    }
</script>


````

Please remember to refresh token every time you submit the form if needed:

````vue
 this.$refs.captcha.execute();
````

###  or Add site key directly into GoogleReCaptchaV3 component

Alternatively, I believe most of cases your site key will never be changed, so you could just modify the original published component to have sitekey hard-coded in.

For instance, open published file and find code below:
````vue
        ....
        siteKey: {
                  type: String,
                  required: false, // set to true if you don't want to store the siteKey in this component
                  default: 'Your Site Key Here' // set siteKey here if you want to store it in this component
              },
       ....

````


## Advanced Usage <a name="advanced-usage" />

### Custom implementation on Config

For some users, they might store the config details in their own storage e.g database. You can create your own class and implement:

```
TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\ReCaptchaConfigV3Interface
```

Remember to register it in your own service provider

``` php
     $this->app->bind(
                ReCaptchaConfigV3Interface::class,
                YourOwnCustomImplementation::class
            );
```

### Custom implementation on Request method

The package has two default options to verify: Guzzle and Curl, if you want to use your own request method, You can create your own class and implement
```
TimeHunter\LaravelGoogleReCaptchaV3\Interfaces\RequestClientInterface
```

Remember to register it in your own service provider
``` php
     $this->app->bind(
                RequestClientInterface::class,
                YourOwnCustomImplementation::class
            );
```


## Contributors  <a name="contributors" />

Thank you for the following contributors, You guys are the BEST!

* [@xalunda](https://github.com/xalunda)
* [@Fluxlicious](https://github.com/Fluxlicious)
* [@vinsonyung](https://github.com/vinsonyung)
* [@demiurge-ash](https://github.com/demiurge-ash)
* [@lxlang](https://github.com/lxlang)
* [@Indianos](https://github.com/Indianos)
* [@ericp-mrel](https://github.com/ericp-mrel)
* [@QuentinBontemps](https://github.com/QuentinBontemps)
* [@alr2413](https://github.com/alr2413)


## Security

If you discover any security related issues, please email ryandadeng@gmail.com instead of using the issue tracker.


## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/timehunter/laravel-google-recaptcha-v3.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/timehunter/laravel-google-recaptcha-v3.svg?style=flat-square
[ico-coverage]: https://coveralls.io/repos/github/RyanDaDeng/laravel-google-recaptcha-v3/badge.svg?branch=master&service=github
[ico-build]: https://travis-ci.org/RyanDaDeng/laravel-google-recaptcha-v3.svg?branch=master
[ico-styleci]: https://github.styleci.io/repos/146857583/shield
[ico-unstable]: https://poser.pugx.org/timehunter/laravel-google-recaptcha-v3/v/unstable

[link-packagist]: https://packagist.org/packages/timehunter/laravel-google-recaptcha-v3
[link-downloads]: https://packagist.org/packages/timehunter/laravel-google-recaptcha-v3
[link-author]: https://github.com/ryandadeng
[link-coverage]: https://coveralls.io/github/RyanDaDeng/laravel-google-recaptcha-v3?branch=master
[link-build]: https://app.travis-ci.com/github/RyanDaDeng/laravel-google-recaptcha-v3
[link-styleci]: https://github.styleci.io/repos/146857583
[link-unstable]: https://packagist.org/packages/timehunter/laravel-google-recaptcha-v3
