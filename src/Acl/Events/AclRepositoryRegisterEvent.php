<?php

namespace Zdrojowa\CmsKernel\Acl\Events;

use Zdrojowa\CmsKernel\Contracts\Acl\Repository\AclRepository;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class AclRepositoryRegisterEvent
 * @package Zdrojowa\CmsKernel\Acl\Events
 */
class AclRepositoryRegisterEvent extends CmsKernelEvent
{

    /**
     * @var AclRepository
     */
    public $repository;

    /**
     * AclRepositoryRegisterEvent constructor.
     *
     * @param AclRepository $repository
     */
    public function __construct(AclRepository $repository)
    {
        $this->repository = $repository;
    }
}
