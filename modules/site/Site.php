<?php

namespace modules\site;

use modules\site\base\ModuleTrait;
use modules\site\behaviors\UserBehavior;
use modules\site\bundles\site\SiteBundle;

use Craft;
use craft\elements\Category;
use craft\elements\Entry;
use craft\elements\User;
use craft\events\DefineBehaviorsEvent;
use craft\events\RegisterElementSourcesEvent;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\events\TemplateEvent;
use craft\i18n\Formatter;
use craft\services\Plugins;
use craft\web\UrlManager;
use craft\web\View;

use yii\base\Event;

class Site extends \yii\base\Module
{
    // Traits
    // =========================================================================

    use ModuleTrait;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        Craft::setAlias('@modules/site', __DIR__);

        if (Craft::$app->getRequest()->getIsConsoleRequest()) {
            $this->controllerNamespace = 'modules\site\console\controllers';
        }

        Craft::$container->set(Formatter::class, function($container, $params, $config) {
            $config['dateTimeFormats']['short']['date'] = 'yyyy-MM-dd';
            $config['dateTimeFormats']['short']['datetime'] = 'yyyy-MM-dd HH:mm';
            return new Formatter($config);
        });

        $this->_setModuleComponents();

        Event::on(Plugins::class, Plugins::EVENT_AFTER_LOAD_PLUGINS, function() {
            $this->_registerUrlRules();
            $this->_registerTemplateRoots();
            $this->_registerElementBehaviors();
            $this->_registerElementEvents();
            $this->_registerElementSources();
            $this->_registerAssetBundles();
        });
    }

    // Private Methods
    // =========================================================================

    /**
     * Register url rules.
     */
    private function _registerUrlRules(): void
    {
        Event::on(UrlManager::class, UrlManager::EVENT_REGISTER_CP_URL_RULES, function(RegisterUrlRulesEvent $event) {
            $rules = [
                'test' => 'site/test/index',
            ];

            $event->rules = array_merge($event->rules, $rules);
        });
    }

    /**
     * Register template roots.
     */
    private function _registerTemplateRoots(): void
    {
        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS, function(RegisterTemplateRootsEvent $event) {
            if (is_dir($baseDir = $this->getBasePath().DIRECTORY_SEPARATOR.'templates')) {
                $event->roots[ $this->id ] = $baseDir;
            }
        });
    }

    /**
     * Register element behaviors.
     */
    private function _registerElementBehaviors(): void
    {
        // User
        // -------------------------------------------------------------------------

        Craft::$app->getUser()->attachBehaviors([
            UserBehavior::class,
        ]);

        Event::on(User::class, User::EVENT_DEFINE_BEHAVIORS, function (DefineBehaviorsEvent $event) {
            $event->sender->attachBehaviors([
                UserBehavior::class,
            ]);
        });
    }

    /**
     * Register element events.
     */
    private function _registerElementEvents(): void
    {
        // Category
        // -------------------------------------------------------------------------

        // Before saving a category
        Event::on(Category::class, Category::EVENT_BEFORE_SAVE, [$this->getCategory(), 'beforeSaveHandler']);

        // Entry
        // -------------------------------------------------------------------------

        // Before saving an entry
        Event::on(Entry::class, Entry::EVENT_BEFORE_SAVE, [$this->getEntry(), 'beforeSaveHandler']);

        // User
        // -------------------------------------------------------------------------

        // Before saving a user
        Event::on(User::class, User::EVENT_BEFORE_SAVE, [$this->getUser(), 'beforeSaveHandler']);
    }

    /**
     * Register element sources.
     */
    private function _registerElementSources(): void
    {
        // Entry
        // -------------------------------------------------------------------------

        Event::on(Entry::class, Entry::EVENT_REGISTER_SOURCES, function (RegisterElementSourcesEvent $event) {
            foreach ($event->sources as $key => $source) {
                $sourceKey = $source['key'] ?? null;

                // Remove `All entries` source
                if ($sourceKey === '*') {
                    unset($event->sources[$key]);
                }
            }
        });

        // User
        // -------------------------------------------------------------------------

        Event::on(User::class, User::EVENT_REGISTER_SOURCES, function(RegisterElementSourcesEvent $event) {
            $isAdmin = Craft::$app->getUser()->getIsAdmin();

            if (!$isAdmin) {
                foreach($event->sources as $key => $source) {
                    $sourceKey = $source['key'] ?? null;

                    // Hide `Administrator` users from `All users` source
                    if ($sourceKey === '*') {
                        $event->sources[$key]['criteria'] = [
                            'admin' => false,
                        ];
                    }

                    // Remove `Administrators` source
                    if ($sourceKey === 'admins') {
                        unset($event->sources[$key]);
                    }
                }
            }
        });
    }

    /**
     * Register asset bundles.
     */
    private function _registerAssetBundles(): void
    {
        if (!Craft::$app->getRequest()->getIsCpRequest()) {
            return;
        }

        Event::on(View::class, View::EVENT_BEFORE_RENDER_TEMPLATE, function(TemplateEvent $event) {
            Craft::$app->getView()->registerAssetBundle(SiteBundle::class);
        });
    }
}
