<?php

namespace Selene\Models;

use Illuminate\Database\Eloquent\Model;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\Core;

/**
 * Class PermissionPackage
 * @package Selene\Models
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
        if($this->anchors === null || !is_array($this->anchors)) return false;

        foreach ($this->anchors as $anchor) {
            if ($anchor === Config::get(Core::ADMIN_ANCHOR) || $anchor === $permission) return true;
        }

        return false;
    }

}
