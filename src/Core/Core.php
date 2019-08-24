<?php

namespace Zdrojowa\CmsKernel\Core;

use Zdrojowa\CmsKernel\Contracts\Acl\AclRepositoryInterface;
use Zdrojowa\CmsKernel\Contracts\Core\CoreInterface;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;
use Illuminate\Support\Facades\Log;

/**
 * Class Core
 * @package Zdrojowa\CmsKernel\Core
 */
class Core implements CoreInterface
{

    /**
     * @var string
     */
    protected $version = '0.0.1';

    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = null): CoreInterface
    {
        Log::log($level, $message, $context ?? []);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function aclRepository(): ?AclRepositoryInterface
    {
        return app(CoreModulesEnum::ACL_REPOSITORY);
    }

    /**
     * @inheritdoc
     */
    public function moduleManager(): ?ModuleManagerInterface
    {
        return app(CoreModulesEnum::MODULE_MANAGER);
    }

    /**
     * @inheritdoc
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}
