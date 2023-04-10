<?php

namespace Dskripchenko\YandexSmartCaptcha\Components;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class YandexSmartCaptcha
{
    /**
     * @var string
     */
    protected $clientKey;

    /**
     * @var string
     */
    protected $serverKey;


    /**
     * @var string
     */
    protected $url;

    /**
     * @param string $clientKey
     * @param string $serverKey
     * @param string $url
     */
    public function __construct(string $clientKey, string $serverKey, string $url)
    {
        $this->clientKey = $clientKey;
        $this->serverKey = $serverKey;
        $this->url = $url;
    }

    /**
     * @param string $token
     * @param string $ip
     * @param bool $throwable
     *
     * @return bool
     * @throws GuzzleException
     * @throws Exception
     */
    public function validate(string $token, string $ip, bool $throwable = false): bool
    {
        $response = $this->getClient()->request('GET', '/validate', [
            'query' => [
                'secret' => $this->serverKey,
                'token' => $token,
                'ip' => $ip,
            ]
        ]);

        $code = $response->getStatusCode();
        $contents = $response->getBody()->getContents();

        if ($code != 200) {
            return $this->hasError(
                "Yandex Smart Captcha Error: {$code}",
                [
                    'contents' => $contents
                ],
                $throwable
            );
        }

        $data = json_decode($contents, true);
        if (!$data) {
            return $this->hasError(
                "Yandex Smart Captcha Error: {$code}",
                [
                    'contents' => $contents
                ],
                $throwable
            );
        }

        return data_get($data, 'status') === 'ok';
    }

    /**
     * @param string $message
     * @param array $context
     * @param bool $throwable
     *
     * @return false
     * @throws Exception
     */
    protected function hasError(string $message, array $context, bool $throwable = false): bool
    {
        if (!$throwable) {
            Log::error($message, $context);
            return false;
        }
        throw new Exception($message);
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        return new Client([
            'base_uri' => $this->url,
        ]);
    }
}
