<?php

namespace modules\site\base;

use modules\site\services\CategoryService;
use modules\site\services\EntryService;
use modules\site\services\GqlService;
use modules\site\services\UserService;

/**
 * @property-read CategoryService $category
 * @property-read EntryService $entry
 * @property-read GqlService $gql
 * @property-read UserService $user
 */
trait ModuleTrait
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the category service.
     *
     * @return CategoryService
     */
    public function getCategory(): CategoryService
    {
        return $this->get('category');
    }

    /**
     * Returns the entry service.
     *
     * @return EntryService
     */
    public function getEntry(): EntryService
    {
        return $this->get('entry');
    }

    /**
     * Returns the gql service.
     *
     * @return GqlService
     */
    public function getGql(): GqlService
    {
        return $this->get('gql');
    }

    /**
     * Returns the user service.
     *
     * @return UserService
     */
    public function getUser(): UserService
    {
        return $this->get('user');
    }

    // Private Methods
    // =========================================================================

    /**
     * Sets the components of the module.
     */
    private function _setModuleComponents(): void
    {
        $this->setComponents([
            'category' => CategoryService::class,
            'entry' => EntryService::class,
            'gql' => GqlService::class,
            'user' => UserService::class,
        ]);
    }
}
