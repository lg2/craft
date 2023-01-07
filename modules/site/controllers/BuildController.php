<?php

namespace modules\site\controllers;

use modules\site\jobs\BuildJob;

use Craft;
use craft\helpers\Queue;

class BuildController extends BaseController
{
    /**
     * Create a background job to run the build webhook.
     */
    public function actionRunWebhook(): void
    {
        Queue::push(new BuildJob([
            'description' => Craft::t('site', 'Publish website'),
        ]));

        $this->setSuccessFlash(Craft::t('site', 'Publish website launched.'));
    }
}
