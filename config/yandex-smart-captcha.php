<?php

return [
    'enable' => env('YANDEX_SMART_CAPTCHA_ENABLE', false),
    'url' => env('YANDEX_SMART_CAPTCHA_URL', 'https://smartcaptcha.yandexcloud.net'),
    'client_key' => env('YANDEX_SMART_CAPTCHA_CLIENT_KEY'),
    'server_key' => env('YANDEX_SMART_CAPTCHA_SERVER_KEY'),
    'error_message' => env('YANDEX_SMART_CAPTCHA_ERROR_MESSAGE', 'Smart captcha validation error'),
];
