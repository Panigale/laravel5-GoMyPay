## Laravel5-GoMyPay

Laravel5-GoMyPay is a laravel package for you to simple use GoMyPay payment system.

## Installation

```
composer require Panigale/laravel5-GoMyPay
```

In .env add, you can register on

```
GOMYPAY_STORECODE=your store code
GOMYPAY_TRADECODE=your trade code
GOMYPAY_CALLBACK=custom callback url
GOMYPAY_BACKEND=custom backend recevice url

```

Publish config.

```
php artisan vendor:publish --provider="Panigale\GoMyPay\GoMyPayServiceProvider"
```

## Basic Usage

It's very simple to use this package:

```
GoMyPay::payBy($paymentType)
       ->withAmount($amount)
       ->withUser($name ,$email ,$phone)
       ->create()
```

Then it well return an array include every fields for GoMyPay required. And you need to do is post this fields to GoMyPay. 

## License

The Laravel5-GoMyPay is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
