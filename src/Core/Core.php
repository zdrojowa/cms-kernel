<?php

namespace Zdrojowa\CmsKernel\Core;

use Illuminate\Support\Facades\Log;
use Zdrojowa\CmsKernel\Contracts\Acl\Repository\AclRepository;
use Zdrojowa\CmsKernel\Contracts\Core\Core as CoreContract;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManager;
use Zdrojowa\CmsKernel\Support\Enums\Core\CoreModules;

/**
 * Class Core
 * @package Zdrojowa\CmsKernel\Core
 */
class Core implements CoreContract
{

    /**
     * @var string
     */
    public $version = '0.0.1';

    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = null): CoreContract
    {
        Log::log($level, $message, $context ?? []);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function aclRepository(): ?AclRepository
    {
        return app(CoreModules::ACL_REPOSITORY);
    }

    /**
     * @inheritdoc
     */
    public function moduleManager(): ?ModuleManager
    {
        return app(CoreModules::MODULE_MANAGER);
    }

    /**
     * @inheritdoc
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}
