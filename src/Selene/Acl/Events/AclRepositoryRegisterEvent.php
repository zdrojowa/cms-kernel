<?php

namespace Selene\Acl\Events;

use Selene\Contracts\Acl\Repository\AclRepository;
use Selene\Events\CmsKernelEvent;

/**
 * Class AclRepositoryRegisterEvent
 * @package Selene\Acl\Events
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
