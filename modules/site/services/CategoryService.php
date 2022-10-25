<?php

namespace modules\site\services;

use modules\site\helpers\ElementHelper;

use craft\elements\Category;
use craft\events\ModelEvent;

class CategoryService extends \craft\base\Component
{
    // Public Methods
    // =========================================================================

    /**
     * Before saving a category.
     *
     * @param ModelEvent $event
     */
    public function beforeSaveHandler(ModelEvent $event): void
    {
        /** @var Category $category */
        $category = $event->sender;

        if (!$category->title || ElementHelper::isDraftOrRevision($category)) {
            return;
        }

        // Update the slug based on category title
        $category->slug = ElementHelper::generateSlug((string) $category->title);
    }
}
