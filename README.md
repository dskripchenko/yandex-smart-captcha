## Installation

```
$ php composer.phar require dskripchenko/yandex-smart-captcha "@dev"
```

or add

```
"dskripchenko/yandex-smart-captcha": "@dev"
```

to the ```require``` section of your `composer.json` file.


## Usage
Validation with rules 
```php

return [
    'token' => 'yandex_smart_captcha'
];
```

Validation with value
```php
use \Dskripchenko\YandexSmartCaptcha\Facades\YandexSmartCaptcha;

$token = '...token value';
$ip = 'ip address or null';
$throwable = true; 
$valid = YandexSmartCaptcha::validate($token, $ip, $throwable);
```
