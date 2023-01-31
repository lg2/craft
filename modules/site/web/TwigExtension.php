<?php

namespace modules\site\web;

use modules\site\helpers\StringHelper;

use Craft;
use craft\base\Element;
use craft\helpers\App;

use Twig\TwigFunction;

class TwigExtension extends \Twig\Extension\AbstractExtension
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getFunctions(): array
    {
        return [

            new TwigFunction('getPreviewUrl', function(Element $element) {
                $url = null;
                $site = $element->getSite();

                if ($site->handle === 'en') {
                    $url = App::env('PREVIEW_EN_URL');
                }

                if ($site->handle === 'fr') {
                    $url = App::env('PREVIEW_FR_URL');
                }

                if (empty($url)) {
                    $url = App::env('PREVIEW_URL');
                }

                if (empty($url)) {
                    $url = $site->getBaseUrl();
                }

                $url = StringHelper::ensureRight($url, '/');

                if (!$element->getIsHomepage()) {
                    $url .= $element->uri;
                }

                if (Craft::$app->getConfig()->getGeneral()->addTrailingSlashesToUrls) {
                    $url = StringHelper::ensureRight($url, '/');
                }

                return $url.'?preview=true';
            }),

        ];
    }
}
