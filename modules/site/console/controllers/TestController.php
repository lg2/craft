<?php

namespace modules\site\console\controllers;

use craft\helpers\App;
use craft\helpers\Console;

use yii\console\ExitCode;

class TestController extends \yii\console\Controller
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        App::maxPowerCaptain();
        parent::init();
    }

    /**
     * Test console command.
     */
    public function actionIndex(): int
    {
        $this->stdout('Test console command'.PHP_EOL, Console::FG_GREEN);
        return ExitCode::OK;
    }
}
