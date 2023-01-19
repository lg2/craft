<?php

namespace modules\site\base;

use modules\site\services\BuildService;
use modules\site\services\CacheService;
use modules\site\services\CategoryService;
use modules\site\services\EntryService;
use modules\site\services\GqlService;
use modules\site\services\UserService;

/**
 * @property-read BuildService $build
 * @property-read CacheService $cache
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
     * Returns the build service.
     *
     * @return BuildService
     */
    public function getBuild(): BuildService
    {
        return $this->get('build');
    }

    /**
     * Returns the cache service.
     *
     * @return CacheService
     */
    public function getCache(): CacheService
    {
        return $this->get('cache');
    }

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
            'build' => BuildService::class,
            'cache' => CacheService::class,
            'category' => CategoryService::class,
            'entry' => EntryService::class,
            'gql' => GqlService::class,
            'user' => UserService::class,
        ]);
    }
}
