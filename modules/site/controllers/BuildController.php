<?php

namespace modules\site\controllers;

use modules\site\Site;
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
        Site::getInstance()->getCache()->clearCaches();
        Queue::push(new BuildJob());

        $this->setSuccessFlash(Craft::t('site', 'Publish website launched.'));
    }
}
