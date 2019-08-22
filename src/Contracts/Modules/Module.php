<?php

namespace Zdrojowa\CmsKernel\Contracts\Modules;

use Exception;
use ReflectionClass;
use ReflectionException;
use Route;
use Symfony\Component\Yaml\Yaml;
use Validator;
use Zdrojowa\CmsKernel\Contracts\Acl\AclPresence;
use Zdrojowa\CmsKernel\Facades\AclRepository;
use Zdrojowa\CmsKernel\Facades\Booter;
use Zdrojowa\CmsKernel\Facades\Core;
use Zdrojowa\CmsKernel\Facades\MenuRepository;
use Zdrojowa\CmsKernel\Menu\MenuPresence;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
use Zdrojowa\CmsKernel\Utils\Enums\ModuleConfigEnum;
use Zdrojowa\CmsKernel\Utils\Module\ModuleUtils;
use Zdrojowa\CmsKernel\Utils\Traits\Propertiable;
use Zdrojowa\CmsKernel\Utils\Variabler\Variabler;

/**
 * Class Module
 * @package Zdrojowa\CmsKernel\Contracts\Modules
 */
abstract class Module
{
    use Propertiable;

    /**
     * @var array
     */
    protected $requiredProperties = ['name', 'version', 'aclAnchor', 'aclName', 'routePrefix'];
    /**
     * @var array
     */
    protected $optionalProperties = ['routes'];

    /**
     * @var array
     */
    protected $propertiesRules = [
        'name' => 'string',
        'version' => 'string',
        'aclAnchor' => 'string',
        'aclName' => 'string',
        'routePrefix' => 'string',
    ];

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $version;
    /**
     * @var
     */
    private $routes;

    /**
     * @var
     */
    private $apiRoutes;

    /**
     * @var array|null
     */
    private $permissions;

    /**
     * @var string
     */
    private $aclAnchor;

    /**
     * @var string
     */
    private $aclName;

    /**
     * @var
     */
    private $routePrefix;

    /**
     * @var array
     */
    private $menu;

    /**
     * Module constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->loadConfig();
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
     * @throws Exception
     */
    final public function loadConfig()
    {
        $this->routes = ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_ROUTES_FILE(), false);
        $this->apiRoutes = ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_ROUTES_API_FILE(), false);
        $this->permissions = ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_PERMISSIONS_FILE(), false);
        $this->menu = ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_MENU_FILE());

        $moduleData = ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_CONFIG_FILE(), true) ?? [];

        $this->bindProperties($moduleData, $this->requiredProperties, $this->propertiesRules, true);
        $this->bindProperties($moduleData, $this->optionalProperties, $this->propertiesRules, false);

        AclRepository::addPresence($this, AclPresence::createPresenceFromData($this->permissions));
        MenuRepository::addPresence($this, MenuPresence::createPresenceFromData($this->menu));

        $moduleReflection = new ReflectionClass($this);
        $configFile = ModuleConfigEnum::MODULE_EXTRA_FILE;
        $configFile = Variabler::replace($this, ModuleConfigEnum::MODULE_EXTRA_FILE);

        $file = base_path(CoreEnum::MODULES_CONFIG_DIR) . "/" . $configFile;
        if (file_exists($file)) {
            $extra = array_merge(ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_EXTRA_FILE()) ?? [], Yaml::parseFile($file, Yaml::PARSE_OBJECT) ?? []);
        } else {
            $extra = ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_EXTRA_FILE() ?? []);
        }

        $this->bindProperties($extra, array_keys($extra));
        $this->mapsRoutes();
        $this->mapsRoutes(true);
    }

    /**
     * @param bool $api
     */
    final private function mapsRoutes($api = false)
    {
        $routes = $api ? $this->apiRoutes : $this->routes;

        if (!$this->checkRouteConfigStructure($routes)) return;

        foreach ($routes as $routeName => $routeConfig) {
            if ($this->checkRouteStructure($routeConfig)) {

                foreach ($routeConfig as $propertyName => $routeProperty) {
                    if(is_array($routeProperty)) continue;
                    $routeConfig[$propertyName] = Variabler::replace($this, $routeProperty);
                }

                if (!isset($routeConfig['methods'])) $routeConfig['methods'] = ConfigUtils::getAvailableHttpMethods();

                Route::match($routeConfig['methods'], $api ? '/api' . $routeConfig['path'] : $routeConfig['path'], $routeConfig['controller'])->middleware($api ? 'api' : [])->middleware($routeConfig['middlewares'] ?? [])->name($this->getRoutePrefix() . "::" . $routeName);
            }
        }
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
    final public function getRoutes(): array
    {
        return $this->routes ?? [];
    }

    /**
     * @param string $route
     * @param array $data
     *
     * @return string
     */
    final public function route(string $route, array $data = [])
    {
        return route($this->routePrefix . "::" . $route, $data);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return void|null
     * @throws ReflectionException
     */
    public static function __callStatic($name, $arguments)
    {
        if(!Booter::isCmsEnabled() || !Core::hasModuleManager()) return;

        $reflection = new ReflectionClass(get_called_class());

        return Core::getModuleManager()->getModule($reflection->getShortName())->$name ?? null;
    }
}
