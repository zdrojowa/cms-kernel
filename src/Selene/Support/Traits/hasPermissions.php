<?php

namespace Selene\Support\Traits;

use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\Core;

/**
 * Trait hasPermissions
 * Trait for using in authenticatable models to check permissions based on table which can be configured in config file
 *
 * @package Selene\Support\Traits
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
        return $this->hasOne('Selene\Models\PermissionPackage', 'id', Config::get(Core::USERS_TABLE_COLUMN));
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
        if($this->permissions === null) return false;
        
        return $this->permissions->hasPermission($permission);
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
