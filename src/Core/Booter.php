<?php

namespace Zdrojowa\CmsKernel\Core;

use Illuminate\Support\Collection;
use Zdrojowa\CmsKernel\Contracts\Core\BooterInterface;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\BooterEnum;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Class Booter
 * @package Zdrojowa\CmsKernel\Core
 */
class Booter implements BooterInterface
{

    /**
     * @var array
     */
    protected $errors;

    /**
     * @var Collection
     */
    protected $booted;

    /**
     * Booter constructor.
     */
    public function __construct()
    {
        $this->errors = [];
        $this->booted = new Collection();

        foreach (CoreModulesEnum::toArray() as $coreModule) {
            $this->booted->put($coreModule, false);
        }
    }

    /**
     * @return bool
     */
    public function hasError(): bool
    {
        if (count($this->errors) === 0) return false;

        return true;
    }

    /**
     * @param string $error
     *
     * @return BooterInterface
     */
    public function addError(string $error): BooterInterface
    {
        array_push($this->errors, $error);

        return $this;
    }

    /**
     * @return array|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function canBoot(): bool
    {
        return ConfigUtils::coreConfig(CoreEnum::CMS_ENABLED_OPTION);
    }

    /**
     * @param CoreModulesEnum $coreModule
     *
     * @return bool
     */
    public function isCoreModuleBooted(CoreModulesEnum $coreModule): bool
    {
        return $this->booted->get($coreModule);
    }

    /**
     * @param CoreModulesEnum $coreModule
     *
     * @return BooterInterface
     */
    public function setCoreModuleBooted(CoreModulesEnum $coreModule): BooterInterface
    {
        $this->booted->put($coreModule->getValue(), true);

        return $this;
    }

    /**
     * @return bool
     */
    public function allCoreModulesBooted(): bool
    {
        foreach ($this->booted as $booted) {
            if (!$booted) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return Collection
     */
    public function getCoreModulesStatus(): Collection
    {
        return $this->booted;
    }
}
