<?php

namespace modules\site\services;

use craft\events\SectionEvent;

class SectionService extends \craft\base\Component
{
    // Public Methods
    // =========================================================================

    /**
     * Before saving a section.
     *
     * @param SectionEvent $event
     */
    public function beforeSaveSectionHandler(SectionEvent $event): void
    {
        if (!$event->isNew) {
            return;
        }

        // Set default preview target
        $event->section->previewTargets = [[
            'label' => 'Page',
            'urlFormat' => '{{ getPreviewUrl(object) }}',
            'refresh' => true,
        ]];
    }
}
