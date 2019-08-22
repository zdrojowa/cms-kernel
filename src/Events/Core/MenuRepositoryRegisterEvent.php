<?php

namespace Zdrojowa\CmsKernel\Events\Core;

use Zdrojowa\CmsKernel\Menu\MenuRepository;

/**
 * Class MenuRepositoryRegisterEvent
 * @package Zdrojowa\CmsKernel\Events\Core
 */
class MenuRepositoryRegisterEvent
{
    /**
     * @var MenuRepository
     */
    public $repository;

    /**
     * MenuRepositoryRegisterEvent constructor.
     *
     * @param MenuRepository $repository
     */
    public function __construct(MenuRepository $repository)
    {
        $this->repository = $repository;
    }
}
