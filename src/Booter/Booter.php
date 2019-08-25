<?php

namespace Zdrojowa\CmsKernel\Booter;

use Illuminate\Support\Collection;
use Zdrojowa\CmsKernel\Contracts\Booter\Booter as BooterContract;
use Zdrojowa\CmsKernel\Support\Config\Config;
use Zdrojowa\CmsKernel\Support\Enums\Core\Core;
use Zdrojowa\CmsKernel\Support\Enums\Core\CoreModules;

/**
 * Class Booter
 * @package Zdrojowa\CmsKernel\Booter
 */
class Booter implements BooterContract
{

    /**
     * @var string
     */
    public $version = '0.0.1';

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

        foreach (CoreModules::toArray() as $coreModule) {
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
    public function addError(string $error): BooterContract
    {
        array_push($this->errors, $error);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @inheritdoc
     */
    public function canBoot(): bool
    {
        return Config::get(Core::ENABLED);
    }

    /**
     * @inheritdoc
     */
    public function isCoreModuleBooted(CoreModules $coreModule): bool
    {
        return $this->booted->get($coreModule->getValue());
    }

    /**
     * @inheritdoc
     */
    public function setCoreModuleBooted(CoreModules $coreModule): BooterContract
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
