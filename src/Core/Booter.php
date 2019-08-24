<?php

namespace Zdrojowa\CmsKernel\Core;

use Illuminate\Support\Collection;
use Zdrojowa\CmsKernel\Contracts\Core\BooterInterface;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;

/**
 * Class Booter
 * @package Zdrojowa\CmsKernel\Core
 */
class Booter implements BooterInterface
{

    protected $version = '0.0.1';

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
     * @inheritdoc
     */
    public function hasError(): bool
    {
        if (count($this->errors) === 0) return false;

        return true;
    }

    /**
     * @inheritdoc
     */
    public function addError(string $error): BooterInterface
    {
        array_push($this->errors, $error);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * @inheritdoc
     */
    public function canBoot(): bool
    {
        return ConfigUtils::coreConfig(CoreEnum::CMS_ENABLED_OPTION);
    }

    /**
     * @inheritdoc
     */
    public function isCoreModuleBooted(CoreModulesEnum $coreModule): bool
    {
        return $this->booted->get($coreModule);
    }

    /**
     * @inheritdoc
     */
    public function setCoreModuleBooted(CoreModulesEnum $coreModule): BooterInterface
    {
        $this->booted->put($coreModule->getValue(), true);

        return $this;
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    public function getCoreModulesStatus(): Collection
    {
        return $this->booted;
    }

    /**
     * @inheritdoc
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}
