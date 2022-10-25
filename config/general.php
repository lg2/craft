<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see \craft\config\GeneralConfig
 */

use craft\helpers\App;

return [

    '*' => [

        'baseCpUrl' => App::env('PRIMARY_SITE_URL'),

        'aliases' => [
            '@web' => App::env('PRIMARY_SITE_URL'),
        ],

        'allowAdminChanges' => App::env('ALLOW_ADMIN_CHANGES'),

        'enableGql' => true,
        'headlessMode' => true,
        'sendPoweredByHeader' => false,

        'defaultCpLanguage' => 'fr',
        'defaultCpLocale' => 'fr-CA',

        'cpTrigger' => 'admin',
        'postCpLoginRedirect' => 'entries',

        'allowUppercaseInSlug' => false,
        'convertFilenamesToAscii' => true,
        'limitAutoSlugsToAscii' => true,
        'omitScriptNameInUrls' => true,

        'maxRevisions' => 5,

    ],

    'dev' => [

        'devMode' => true,
        'disallowRobots' => true,
        'enableGraphqlCaching' => false,

        'testToEmailAddress' => [
            'example@lg2.com' => 'Craft - Dev',
        ],

    ],

    'staging' => [

        'allowUpdates' => false,
        'disallowRobots' => true,

        'testToEmailAddress' => [
            'example@lg2.com' => 'Craft - Staging',
        ],

    ],

    'production' => [

        'allowUpdates' => false,
        'enableGraphqlIntrospection' => false,

    ],

];
