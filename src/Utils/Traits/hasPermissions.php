<?php

namespace Zdrojowa\CmsKernel\Utils\Traits;

use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;

/**
 * Trait hasPermissions
 * Trait for using in authenticatable models to check permissions based on table which can be configured in config file
 *
 * @package Zdrojowa\CmsKernel\Utils\Traits
 */
trait hasPermissions
{

    /**
     * Get model permission package
     *
     * @return mixed
     */
    public function permissions()
    {
        return $this->hasOne('Zdrojowa\CmsKernel\Models\PermissionPackage', ConfigUtils::coreConfig(CoreEnum::CMS_MIGRATIONS_USERS_TABLE_COLUMN_NAME));
    }

    /**
     * Check if model permission package has given anchor
     *
     * @param string $permission
     *
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) return true;

        return $this->permissions()->hasPermission($permission);
    }

    /**
     * Return bool from model's table
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        $adminColumn = ConfigUtils::coreConfig(CoreEnum::CMS_SUPER_ADMIN_COLUMN_NAME);

        dd($this);

        return $this->$adminColumn;
    }
}
