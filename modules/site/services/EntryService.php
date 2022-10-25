<?php

namespace modules\site\services;

use modules\site\helpers\ElementHelper;

use craft\elements\Entry;
use craft\events\ModelEvent;

class EntryService extends \craft\base\Component
{
    // Public Methods
    // =========================================================================

    /**
     * Before saving an entry.
     *
     * @param ModelEvent $event
     */
    public function beforeSaveHandler(ModelEvent $event): void
    {
        /** @var Entry $entry */
        $entry = $event->sender;

        if (!$entry->title || ElementHelper::isDraftOrRevision($entry)) {
            return;
        }

        // Update the slug based on entry title
        if ($entry->getIsHomepage()) {
            $entry->slug = 'home';
        } else {
            $entry->slug = ElementHelper::generateSlug((string) $entry->title);
        }
    }
}
