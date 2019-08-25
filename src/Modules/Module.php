<?php

namespace Zdrojowa\CmsKernel\Modules;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Yaml\Yaml;
use Zdrojowa\CmsKernel\Acl\Exceptions\AclPresenceDataException;
use Zdrojowa\CmsKernel\Acl\Factories\AclPresenceFactory;
use Zdrojowa\CmsKernel\Contracts\Acl\Presence\AclPresence;
use Zdrojowa\CmsKernel\Contracts\Modules\Module as ModuleContract;
use Zdrojowa\CmsKernel\Exceptions\CmsExceptionHandler;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;
use Zdrojowa\CmsKernel\Support\Facades\MenuRepository;
use Zdrojowa\CmsKernel\Support\Facades\Variabler;
use Zdrojowa\CmsKernel\Menu\MenuPresence;
use Zdrojowa\CmsKernel\Support\Config\Config;
use Zdrojowa\CmsKernel\Support\Enums\Modules\Module as ModuleEnum;
use Zdrojowa\CmsKernel\Support\Enums\Modules\ModuleConfig;
use Zdrojowa\CmsKernel\Support\Facades\ModuleManager as ModuleManagerFacade;
use Zdrojowa\CmsKernel\Support\Modules\Module as ModuleSupport;
use Zdrojowa\CmsKernel\Support\Traits\Propertiable;

/**
 * Class Module
 * @package Zdrojowa\CmsKernel\Modules
 *
 * @property $name
 * @property $version
 * @property $aclAnchor
 * @property $aclName
 * @property $routePrefix
 * @property $menu
 * @property $routes
 * @property $apiRoutes
 * @property $permissions
 *
 * @method static name(): string
 * @method static version(): string
 * @method static aclAnchor(): string
 * @method static aclName(): string
 * @method static routePrefix(): string
 */
abstract class Module implements ModuleContract
{
    use Propertiable;

    protected $requiredProperties = ['name', 'version', 'aclAnchor', 'aclName', 'routePrefix'];

    protected $propertiesRules = [
        'name' => 'string',
        'version' => 'string',
        'aclAnchor' => 'string',
        'aclName' => 'string',
        'routePrefix' => 'string',
    ];

    /**
     * @return mixed|void
     * @throws CmsKernelException
     * @throws Exceptions\ModuleConfigNotFoundException
     * @throws ReflectionException
     */
    public function loadConfig()
    {
        $this->bindExtraProperties();
        $this->bindImportantProperties();

        return;
    }

    public function getAclPresence(): ?AclPresence
    {
        try {
            return (new AclPresenceFactory($this))->create();
        } catch (AclPresenceDataException $e) {
            CmsExceptionHandler::handle($e);

            return null;
        }
    }

    /**
     * @throws Exceptions\ModuleConfigNotFoundException
     * @throws ReflectionException
     * @throws CmsKernelException
     */
    private function bindImportantProperties()
    {
        $this->routes = ModuleSupport::config($this, ModuleConfig::ROUTES_FILE(), false);

        $this->apiRoutes = ModuleSupport::config($this, ModuleConfig::ROUTES_API_FILE(), false);
        $this->permissions = ModuleSupport::config($this, ModuleConfig::PERMISSIONS_FILE(), false);
        $this->menu = ModuleSupport::config($this, ModuleConfig::MENU_FILE());

        $moduleData = ModuleSupport::config($this, ModuleConfig::CONFIG_FILE(), true) ?? [];

        $this->bindProperties($moduleData, $this->requiredProperties ?? [], $this->propertiesRules, true);
        $this->bindProperties($moduleData, $this->optionalProperties ?? [], $this->propertiesRules, false);

        MenuRepository::addPresence($this, MenuPresence::createPresenceFromData($this->menu));
    }

    /**
     * @throws CmsKernelException
     * @throws Exceptions\ModuleConfigNotFoundException
     * @throws ReflectionException
     */
    private function bindExtraProperties()
    {
        $configFile = Variabler::make(ModuleConfig::EXTRA_FILE, $this);

        $file = base_path(ModuleEnum::CONFIG_DIR) . "/" . $configFile;
        if (file_exists($file)) {
            $extra = array_merge(ModuleSupport::config($this, ModuleConfig::EXTRA_FILE()) ?? [], Yaml::parseFile($file, Yaml::PARSE_OBJECT) ?? []);
        } else {
            $extra = ModuleSupport::config($this, ModuleConfig::EXTRA_FILE()) ?? [];
        }

        $this->bindProperties($extra, array_keys($extra));
    }

    /**
     * @param bool $api
     *
     * @return mixed
     */
    public function mapRoutes($api = false): void
    {
        $routes = $api ? $this->apiRoutes : $this->routes;

        if (!$this->checkRouteConfigStructure($routes)) return;

        foreach ($routes as $routeName => $routeConfig) {
            if ($this->checkRouteStructure($routeConfig)) {
                if (!isset($routeConfig['methods'])) $routeConfig['methods'] = Config::getAvailableHttpMethods();

                Route::match($routeConfig['methods'], $api ? '/api' . $routeConfig['path'] : $routeConfig['path'], $routeConfig['controller'])->middleware($api ? 'api' : [])->middleware($routeConfig['middlewares'] ?? [])->name($this->getRoutePrefix() . "::" . $routeName);
            }
        }
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes ?? [];
    }

    /**
     * @return array
     */
    public function getApiRoutes(): array
    {
        return $this->apiRoutes ?? [];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRoutePrefix(): string
    {
        return $this->routePrefix;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getAclAnchor(): string
    {
        return $this->aclAnchor;
    }

    /**
     * @return string
     */
    public function getAclName(): string
    {
        return $this->aclName;
    }

    /**
     * @param $routeConfig
     *
     * @return bool
     */
    final private function checkRouteConfigStructure($routeConfig): bool
    {
        return is_array($routeConfig);
    }

    /**
     * @param $routeConfig
     *
     * @return bool
     */
    final private function checkRouteStructure($routeConfig): bool
    {
        $validator = Validator::make($routeConfig, [
            'path' => 'required|string',
            'controller' => 'required|string',
            'methods' => 'sometimes|array',
            'middlewares' => 'sometimes|array',
        ]);

        return !$validator->fails();
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions ?? [];
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     * @throws ReflectionException
     */
    public static function __callStatic($name, $arguments)
    {
        $reflection = new ReflectionClass(get_called_class());

        return ModuleManagerFacade::getModule($reflection->getShortName())->$name ?? null;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->$name = Variabler::make($value, $this);
    }
}
