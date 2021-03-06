<?php

namespace Selene\Booter;

use Illuminate\Support\Collection;
use Selene\Contracts\Booter\Booter as BooterContract;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\Core;
use Selene\Support\Enums\Core\CoreModules;

/**
 * Class Booter
 * @package Selene\Booter
 */
class Booter implements BooterContract
{

    /**
     * @var string
     */
    public $version = '1.0.0';

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
