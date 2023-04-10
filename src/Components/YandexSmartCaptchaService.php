<?php

namespace Dskripchenko\YandexSmartCaptcha\Components;

use GuzzleHttp\Exception\GuzzleException;

class YandexSmartCaptchaService
{
    /**
     * @var YandexSmartCaptcha
     */
    protected $captcha;

    public function __construct(YandexSmartCaptcha $captcha)
    {
        $this->captcha = $captcha;
    }

    /**
     * @param string $token
     * @param string|null $ip
     * @param bool $throwable
     *
     * @return bool
     * @throws GuzzleException
     */
    public function validate(string $token, string $ip = null, bool $throwable = false): bool
    {
        if (!config('yandex-smart-captcha.enable')) {
            return true;
        }

        if (!$ip) {
            $ip = request()->ip();
        }

        return $this->captcha->validate($token, $ip, $throwable);
    }

}
