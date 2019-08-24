<?php

namespace Zdrojowa\CmsKernel\Core;

use Zdrojowa\CmsKernel\Contracts\Acl\AclRepositoryInterface;
use Zdrojowa\CmsKernel\Contracts\Core\CoreInterface;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManagerInterface;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * @method app($instance)
 */
class Core implements CoreInterface
{

    /**
     * @param $level
     * @param $message
     * @param array|null $context
     *
     * @return CoreInterface
     */
    public function log($level, $message, array $context = null): CoreInterface
    {
        Log::log($level, $message, $context ?? []);

        return $this;
    }

    /**
     * @return AclRepositoryInterface|null
     */
    public function aclRepository(): ?AclRepositoryInterface
    {
        return app(CoreModulesEnum::ACL_REPOSITORY);
    }

    /**
     * @return ModuleManagerInterface|null
     */
    public function moduleManager(): ?ModuleManagerInterface
    {
        return app(CoreModulesEnum::MODULE_MANAGER);
    }
}
