<?php

namespace Selene\Console\Commands;

use Illuminate\Console\Command;
use Selene\Contracts\Modules\ModuleManager;

/**
 * Class ListModuleCommand
 * @package Selene\Console\Commands
 */
class ListModuleCommand extends Command
{

    /**
     * @var string
     */
    protected $signature = 'selene:modules {module?}';

    /**
     * @param ModuleManager $manager
     */
    public function handle(ModuleManager $manager)
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
