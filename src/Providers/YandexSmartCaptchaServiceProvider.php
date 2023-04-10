<?php

namespace Dskripchenko\YandexSmartCaptcha\Providers;

use Dskripchenko\YandexSmartCaptcha\Components\YandexSmartCaptcha;
use Dskripchenko\YandexSmartCaptcha\Components\YandexSmartCaptchaService;
use Exception;
use Illuminate\Support\ServiceProvider;

class YandexSmartCaptchaServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        //Config
        $this->loadConfiguration();

        //Client
        $this->app->bind(YandexSmartCaptcha::class, function () {
            $clientKey = config('yandex-smart-captcha.client_key');
            $serverKey = config('yandex-smart-captcha.server_key');
            $url = config('yandex-smart-captcha.url');
            if (!$clientKey || !$serverKey || !$url) {
                throw new Exception(
                    "Check the definition of environment variables "
                    . "YANDEX_SMART_CAPTCHA_SERVER_KEY, YANDEX_SMART_CAPTCHA_CLIENT_KEY, YANDEX_SMART_CAPTCHA_URL"
                );
            }
            return new YandexSmartCaptcha($clientKey, $serverKey, $url);
        });

        //Facade
        $this->app->singleton('yandex_smart_captcha', YandexSmartCaptchaService::class);

        //Validator
        $this->app->register(YandexSmartCaptchaValidator::class);

        parent::register();
    }

    /**
     * @return void
     */
    protected function loadConfiguration(): void
    {
        $configDirectory = dirname(__DIR__, 2) . '/config';
        $this->mergeConfigFrom("{$configDirectory}/yandex-smart-captcha.php", 'yandex-smart-captcha');
    }

    /**
     * @param $path
     * @param $key
     *
     * @return void
     */
    protected function mergeConfigFrom($path, $key): void
    {
        if (!$this->app->configurationIsCached()) {
            $result = array_merge_deep(require $path, $this->app['config']->get($key, []));
            $this->app['config']->set($key, $result);
        }
    }
}
