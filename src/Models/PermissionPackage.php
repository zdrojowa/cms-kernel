<?php

namespace Zdrojowa\CmsKernel\Models;

use Illuminate\Database\Eloquent\Model;
use Zdrojowa\CmsKernel\Support\Config\Config;
use Zdrojowa\CmsKernel\Support\Enums\Core\Core;

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
        'anchors' => 'array',
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

        $this->setTable(Config::get(Core::PERMISSIONS_TABLE));
    }

    /**
     * @param $permission
     *
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        foreach ($this->anchors as $anchor) {
            if ($anchor === Config::get(Core::ADMIN_ANCHOR) || $anchor === $permission) return true;
        }

        return false;
    }

}
