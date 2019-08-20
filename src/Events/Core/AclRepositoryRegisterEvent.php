<?php

namespace Zdrojowa\InvestmentCMS\Events\Core;

use Zdrojowa\InvestmentCMS\Contracts\Acl\AclRepository;
use Zdrojowa\InvestmentCMS\Events\InvestmentCMSEvent;

class AclRepositoryRegisterEvent extends InvestmentCMSEvent
{

    public $repository;

    public function __construct(AclRepository $repository)
    {
        $this->repository = $repository;
    }
}
