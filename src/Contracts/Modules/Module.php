<?php

namespace Zdrojowa\InvestmentCMS\Contracts\Modules;

use Exception;
use Route;
use Symfony\Component\Yaml\Yaml;
use Validator;
use Zdrojowa\InvestmentCMS\Contracts\Acl\AclPresence;
use Zdrojowa\InvestmentCMS\Exceptions\Acl\AclPresenceDataException;
use Zdrojowa\InvestmentCMS\Facades\AclRepository;
use Zdrojowa\InvestmentCMS\Utils\Config\ConfigUtils;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreEnum;
use Zdrojowa\InvestmentCMS\Utils\Enums\ModuleConfigEnum;
use Zdrojowa\InvestmentCMS\Utils\Module\ModuleUtils;
use Zdrojowa\InvestmentCMS\Utils\Traits\Propertiable;

/**
 * Class Module
 * @package Zdrojowa\InvestmentCMS\Contracts\Modules
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

        $moduleData = ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_CONFIG_FILE(), true) ?? [];

        $this->bindProperties($moduleData, $this->requiredProperties, $this->propertiesRules, true);
        $this->bindProperties($moduleData, $this->optionalProperties, $this->propertiesRules, false);

        $this->mapsRoutes();
        $this->mapsRoutes(true);

        AclRepository::addPresence($this, AclPresence::createPresenceFromData($this->permissions));

        $moduleReflection = new \ReflectionClass($this);
        $configFile = ModuleConfigEnum::MODULE_EXTRA_FILE;
        $configFile = str_replace('%name%', $moduleReflection->getShortName(), $configFile);
        $file = base_path(CoreEnum::MODULES_CONFIG_DIR)."/".$configFile;
        if(file_exists($file)) {
            $extra = array_merge(Yaml::parseFile($file, Yaml::PARSE_OBJECT) ?? [], ModuleUtils::moduleConfig($this, ModuleConfigEnum::MODULE_EXTRA_FILE()) ?? []);

            $this->bindProperties($extra, array_keys($extra));
        }
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

    final public function getRoutes(): array
    {
        return $this->routes ?? [];
    }

    final public function route(string $route, array $data = [])
    {
        return route($this->routePrefix . "::" . $route, $data);
    }
}
