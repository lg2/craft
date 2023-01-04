<?php

namespace modules\site\services;

use Craft;
use craft\helpers\App;

class BuildService extends \craft\base\Component
{
    // Properties
    // =========================================================================

    /**
     * @var string[]
     */
    private array $_envs = [
        'BUILD_URL',
        'BUILD_EN_URL',
        'BUILD_FR_URL',
    ];

    // Public Methods
    // =========================================================================

    /**
     * Returns build time in seconds.
     *
     * @return int
     */
    public function getBuildTime(): int
    {
        $time = (int) Craft::$app->getConfig()->getCustom()->buildTime;
        return max($time, 60);
    }

    /**
     * Run build webhook.
     *
     * @return bool
     */
    public function runWebhook(): bool
    {
        $client = Craft::createGuzzleClient();

        foreach($this->_envs as $env) {
            $url = App::env($env);

            if ($url) {
                try {
                    $response = $client->request('POST', $url);
                } catch(\Throwable $e) {
                    Craft::error('Unable send request to build webhook: '.$e->getMessage(), __METHOD__);
                    return false;
                }

                if ($response->getStatusCode() !== 200) {
                    Craft::error('Invalid response from build webhook: '.$response->getBody(), __METHOD__);
                    return false;
                }
            }
        }

        return true;
    }
}
