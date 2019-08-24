<?php

namespace Zdrojowa\CmsKernel\Modules;

use Exception;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Yaml\Yaml;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleInterface;
use Zdrojowa\CmsKernel\Exceptions\CmsKernelException;
use Zdrojowa\CmsKernel\Facades\Core;
use Zdrojowa\CmsKernel\Facades\MenuRepository;
use Zdrojowa\CmsKernel\Facades\Variabler;
use Zdrojowa\CmsKernel\Factories\Acl\DataArrayAclPresenceFactory;
use Zdrojowa\CmsKernel\Menu\MenuPresence;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;
use Zdrojowa\CmsKernel\Utils\Enums\CoreModulesEnum;
use Zdrojowa\CmsKernel\Utils\Enums\ModuleConfigEnum;
use Zdrojowa\CmsKernel\Utils\Module\ModuleUtils;
use Zdrojowa\CmsKernel\Utils\Traits\Propertiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

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
abstract class Module implements ModuleInterface
{
    use Propertiable;

    /**
     * @var array
     */
    protected $requiredProperties = ['name', 'version', 'aclAnchor', 'aclName', 'routePrefix'];

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
     * @return mixed
     * @throws CmsKernelException
     * @throws ReflectionException
     */
    public function loadConfig()
    {
        $this->bindExtraProperties();
        $this->bindImportantProperties();
    }

    /**
     * @throws CmsKernelException
     * @throws ReflectionException
     * @throws Exception
     */
    private function bindImportantProperties()
    {
            $this->routes = ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_ROUTES_FILE(), false);

            $this->apiRoutes = ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_ROUTES_API_FILE(), false);
            $this->permissions = ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_PERMISSIONS_FILE(), false);
            $this->menu = ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_MENU_FILE());

            $moduleData = ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_CONFIG_FILE(), true) ?? [];

            $this->bindProperties($moduleData, $this->requiredProperties ?? [], $this->propertiesRules, true);
            $this->bindProperties($moduleData, $this->optionalProperties ?? [], $this->propertiesRules, false);

            MenuRepository::addPresence($this, MenuPresence::createPresenceFromData($this->menu));

            app(CoreModulesEnum::ACL_REPOSITORY)->addPresence((new DataArrayAclPresenceFactory($this))->create());
    }

    /**
     * @throws CmsKernelException
     * @throws ReflectionException
     * @throws Exception
     */
    private function bindExtraProperties()
    {
        $configFile = Variabler::make(ModuleConfigEnum::MODULE_EXTRA_FILE, $this);

        $file = base_path(CoreEnum::MODULES_CONFIG_DIR) . "/" . $configFile;
        if (file_exists($file)) {
            $extra = array_merge(ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_EXTRA_FILE()) ?? [], Yaml::parseFile($file, Yaml::PARSE_OBJECT) ?? []);
        } else {
            $extra = ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_EXTRA_FILE()) ?? [];
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
                if (!isset($routeConfig['methods'])) $routeConfig['methods'] = ConfigUtils::getAvailableHttpMethods();

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

        return Core::moduleManager()->getModule($reflection->getShortName())->$name ?? null;
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
