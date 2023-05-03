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

        // Clean the actual slug
        if (!$event->isNew && !empty($category->slug)) {
            $category->slug = ElementHelper::generateSlug((string) $category->slug);
        }

        // Update the slug based on category title
        if (!empty($category->title)) {
            $category->slug = ElementHelper::generateSlug((string) $category->title);
        }
    }
}
