<?php

namespace Zdrojowa\CmsKernel\Utils\Traits;

use Zdrojowa\CmsKernel\Support\Config\Config;
use Zdrojowa\CmsKernel\Support\Enums\Core\Core;

/**
 * Trait hasPermissions
 * Trait for using in authenticatable models to check permissions based on table which can be configured in config file
 *
 * @package Zdrojowa\CmsKernel\Support\Traits
 * @method hasOne($model, string $foreignKey)
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
        return $this->hasOne('Zdrojowa\CmsKernel\Models\PermissionPackage', Config::get(Core::USERS_TABLE_COLUMN));
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
        $adminColumn = Config::get(Core::ADMIN_COLUMN);

        return $this->$adminColumn;
    }
}
