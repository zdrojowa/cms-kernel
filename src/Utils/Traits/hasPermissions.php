<?php

namespace Zdrojowa\InvestmentCMS\Utils\Traits;

use Zdrojowa\InvestmentCMS\Utils\Config\ConfigUtils;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreEnum;

/**
 * Trait hasPermissions
 * @package Zdrojowa\InvestmentCMS\Utils\Traits
 */
trait hasPermissions
{

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->hasOne('Zdrojowa\InvestmentCMS\Models\PermissionPackage', ConfigUtils::coreConfig(CoreEnum::CMS_MIGRATIONS_USERS_TABLE_COLUMN_NAME));
    }

    /**
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
     * @return bool
     */
    public function isAdmin(): bool
    {
        $adminColumn = ConfigUtils::coreConfig(CoreEnum::CMS_SUPER_ADMIN_COLUMN_NAME);

        dd($this);

        return $this->$adminColumn;
    }
}
