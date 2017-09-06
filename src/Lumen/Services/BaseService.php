<?php

namespace Bludata\Lumen\Services;

abstract class BaseService
{
    /**
     * @var Bludata\Doctrine\Common\Interfaces\BaseRepositoryInterface
     */
    protected $mainRepository;

    public function getMainRepository()
    {
        return $this->mainRepository;
    }
}
