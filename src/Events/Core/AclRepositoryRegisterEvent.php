<?php

namespace Zdrojowa\CmsKernel\Events\Core;

use Zdrojowa\CmsKernel\Contracts\Acl\AclRepositoryInterface;
use Zdrojowa\CmsKernel\Events\CmsKernelEvent;

/**
 * Class AclRepositoryRegisterEvent
 * @package Zdrojowa\CmsKernel\Events\Core
 */
class AclRepositoryRegisterEvent extends CmsKernelEvent
{

    /**
     * @var AclRepositoryInterface
     */
    public $repository;

    /**
     * AclRepositoryRegisterEvent constructor.
     *
     * @param AclRepositoryInterface $repository
     */
    public function __construct(AclRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
