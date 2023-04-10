<?php

namespace Dskripchenko\YandexSmartCaptcha\Facades;

use Dskripchenko\YandexSmartCaptcha\Components\YandexSmartCaptchaService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool validate(string $token, string $ip = null, bool $throwable = false)
 * @see YandexSmartCaptchaService
 */
class YandexSmartCaptcha extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'yandex_smart_captcha';
    }
}
