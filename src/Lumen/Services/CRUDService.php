<?php

namespace Bludata\Lumen\Services;

use Bludata\Doctrine\Common\Interfaces\BaseEntityInterface;

abstract class CRUDService extends BaseService
{
    use \Bludata\Lumen\Traits\Services\CreateTrait;
    use \Bludata\Lumen\Traits\Services\ReadTrait;
    use \Bludata\Lumen\Traits\Services\UpdateTrait;
    use \Bludata\Lumen\Traits\Services\DeleteTrait;

    abstract public function prePersistEntity(BaseEntityInterface $entity);
}
