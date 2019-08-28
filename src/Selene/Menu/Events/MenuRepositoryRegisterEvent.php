<?php

namespace Selene\Menu\Events;

use Selene\Menu\MenuRepository;

/**
 * Class MenuRepositoryRegisterEvent
 * @package Selene\Menu\Events
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
