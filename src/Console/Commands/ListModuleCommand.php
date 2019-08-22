<?php

namespace Zdrojowa\CmsKernel\Console\Commands;

use Illuminate\Console\Command;
use Zdrojowa\CmsKernel\Contracts\Core\CoreInterface;

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
     * @param CoreInterface $core
     */
    public function handle(CoreInterface $core)
    {
        $module = $this->argument('module');

        $headers = ['Name', 'Version', 'AclAnchor', 'AclName', 'RoutePrefix'];

        if ($module === null) {


            $data = [];

            foreach ($core->getModuleManager()->getModules() as $module) {
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
