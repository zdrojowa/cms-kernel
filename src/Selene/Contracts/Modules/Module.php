<?php

namespace Selene\Contracts\Modules;

use Selene\Contracts\Acl\Presence\AclPresence;

/**
 * Interface Module
 * @package Selene\Contracts\Modules
 */
interface Module
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
     * @return AclPresence
     */
    public function getAclPresence(): ?AclPresence;

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments);
}
