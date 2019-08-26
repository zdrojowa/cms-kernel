<?php

namespace Selene\Core;

use Illuminate\Support\Facades\Log;
use Selene\Contracts\Acl\Repository\AclRepository;
use Selene\Contracts\Core\Core as CoreContract;
use Selene\Contracts\Modules\ModuleManager;
use Selene\Support\Enums\Core\CoreModules;

/**
 * Class Core
 * @package Selene\Core
 */
class Core implements CoreContract
{

    /**
     * @var string
     */
    public $version = '1.0.0';

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
