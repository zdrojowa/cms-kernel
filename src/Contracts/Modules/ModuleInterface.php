<?php

namespace Zdrojowa\CmsKernel\Contracts\Modules;

/**
 * Interface ModuleInterface
 * @package Zdrojowa\CmsKernel\Contracts\Modules
 */
interface ModuleInterface
{

    /**
     * Method for loading all config files etc.
     * Called in ModuleManagerServiceProvider
     *
     * @return mixed
     */
    public function loadConfig();

    /**
     * @param bool $api
     *
     * @return mixed
     */
    public function mapRoutes($api = false);

    /**
     * @return array
     */
    public function getRoutes(): array;

    /**
     * @return array
     */
    public function getApiRoutes(): array;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getRoutePrefix(): string;

    /**
     * @return string
     */
    public function getVersion(): string;

    /**
     * @return string
     */
    public function getAclAnchor(): string;

    /**
     * @return string
     */
    public function getAclName(): string;

    /**
     * @return array|null
     */
    public function getPermissions(): array;

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments);
}
