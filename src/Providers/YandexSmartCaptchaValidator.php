<?php

namespace Dskripchenko\YandexSmartCaptcha\Providers;

use Dskripchenko\YandexSmartCaptcha\Facades\YandexSmartCaptcha;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator as Factory;
use Illuminate\Validation\Validator;

class YandexSmartCaptchaValidator extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $message = config('yandex-smart-captcha.error_message');
        $rule = 'yandex_smart_captcha';
        $handler = static function (string $attribute, $value, $parameters, Validator $validator) {
            return YandexSmartCaptcha::validate($value);
        };

        Factory::extend($rule, $handler, $message);
    }
}
