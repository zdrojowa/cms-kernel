<?php

namespace Zdrojowa\CmsKernel\Events\Core;

use Zdrojowa\CmsKernel\Contracts\Acl\AclRepository;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

class AclRepositoryRegisterEvent extends CmsKernelEvent
{

    public $repository;

    public function __construct(AclRepository $repository)
    {
        $this->repository = $repository;
    }
}
