<?php

namespace Zdrojowa\CmsKernel\Menu\Events;

use Zdrojowa\CmsKernel\Menu\MenuRepository;

/**
 * Class MenuRepositoryRegisterEvent
 * @package Zdrojowa\CmsKernel\Menu\Events
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
