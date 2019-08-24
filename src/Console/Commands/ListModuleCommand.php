<?php

namespace Zdrojowa\CmsKernel\Console\Commands;

use Illuminate\Console\Command;
use Zdrojowa\CmsKernel\Contracts\Core\CoreInterface;
use Zdrojowa\CmsKernel\Contracts\Modules\ModuleManagerInterface;

/**
 * Class ListModuleCommand
 * @package Zdrojowa\CmsKernel\Console\Commands
 */
class ListModuleCommand extends Command
{

    /**
     * @var string
     */
    protected $signature = 'cms:modules {module?}';

    /**
     * @param ModuleManagerInterface $manager
     */
    public function handle(ModuleManagerInterface $manager)
    {
        $module = $this->argument('module');

        $headers = ['Name', 'Version', 'AclAnchor', 'AclName', 'RoutePrefix'];

        if ($module === null) {


            $data = [];

            foreach ($manager->getModules() as $module) {
                $moduleData = [];
                $moduleData['Name'] = $module->getName();
                $moduleData['Version'] = $module->getVersion();
                $moduleData['AclAnchor'] = $module->getAclAnchor();
                $moduleData['AclName'] = $module->getAclName();
                $moduleData['RoutePrefix'] = $module->getRoutePrefix();

                array_push($data, $moduleData);
            }

            $this->table($headers, $data);
        }

        //TODO GET ONLY ONE MODULE
    }
}
