<?php

namespace Zdrojowa\CmsKernel\Models;

use Illuminate\Database\Eloquent\Model;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;

/**
 * Class PermissionPackage
 * @package Zdrojowa\CmsKernel\Models
 */
class PermissionPackage extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['name', 'anchors'];

    /**
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'anchors' => 'array'
    ];

    /**
     * @var
     */
    private $anchors;

    /**
     * PermissionPackage constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(ConfigUtils::coreConfig(CoreEnum::CMS_MIGRATIONS_PERMISSIONS_TABLE_OPTION));
    }

    /**
     * @param $permission
     *
     * @return bool
     */
    public function hasPermission(string $permission): bool {
        foreach ($this->anchors as $anchor) {
            if($anchor === ConfigUtils::coreConfig(CoreEnum::CMS_SUPER_PERMISSION_ANCHOR) || $anchor === $permission) return true;
        }

        return false;
    }


}
