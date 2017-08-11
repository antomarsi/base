<?php

namespace Bludata\Doctrine\ODM\MongoDB\Entities;

use Bludata\Doctrine\ODM\MongoDB\Traits\SetPropertiesEntityTrait;
use Bludata\Doctrine\Common\Interfaces\BaseEntityInterface;
use Bludata\Doctrine\Common\Interfaces\EntityManagerInterface;
use Bludata\Doctrine\Common\Interfaces\EntityTimestampInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ODM\MongoDB\PersistentCollection;

/**
 * @ODM\MappedSuperclass
 * @ODM\HasLifecycleCallbacks
 */
abstract class BaseEntity implements BaseEntityInterface, EntityTimestampInterface
{
    use SetPropertiesEntityTrait;

    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="timestamp", name="createdAt")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="timestamp", name="updatedAt")
     */
    protected $updatedAt;

    /**
     * @ODM\Field(type="timestamp", nullable=true, name="deletedAt")
     */
    protected $deletedAt;

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * Altera o campo updatedAt para forçar o persist da entity.
     */
    public function forcePersist()
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }

    /**
     * @ODM\PrePersist
     */
    public function prePersist()
    {
        $repository = $this->getRepository();

        if (method_exists($repository, 'preSave')) {
            $repository->preSave($this);
        }

        if (method_exists($repository, 'preSave')) {
            $repository->validate($this);
        }
    }

    /**
     * @ODM\PostPersist
     */
    public function postPersist()
    {
        $repository = $this->getRepository();

        if (method_exists($repository, 'postSave')) {
            $repository->postSave($this);
        }

        if (method_exists($repository, 'postSave')) {
            $repository->validate($this);
        }
    }

    /**
     * @ODM\PreUpdate
     */
    public function preUpdate()
    {
        $repository = $this->getRepository();

        if (method_exists($repository, 'preSave')) {
            $repository->preSave($this);
        }

        if (method_exists($repository, 'preSave')) {
            $repository->validate($this);
        }
    }

    /**
     * @ODM\PostUpdate
     */
    public function postUpdate()
    {
        $repository = $this->getRepository();

        if (method_exists($repository, 'postSave')) {
            $repository->postSave($this);
        }

        if (method_exists($repository, 'postSave')) {
            $repository->validate($this);
        }
    }

    /**
     * @ODM\PreFlush
     */
    public function preFlush()
    {
        $repository = $this->getRepository();

        if (method_exists($repository, 'preFlush')) {
            $repository->preFlush($this);
        }
    }

    public function getRepository()
    {
        return app(EntityManagerInterface::class)->getRepository(get_class($this));
    }

    public function remove($abort = true)
    {
        $this->getRepository()->remove($this, $abort);

        return $this;
    }

    public function restoreRemoved()
    {
        abort(501, 'Not Implemented');
    }

    public function save()
    {
        $this->getRepository()->save($this);

        return $this;
    }

    public function flush($all = true)
    {
        $this->getRepository()->flush($all ? null : $this);

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    protected function getFillable()
    {
        return ['id', 'createdAt', 'updatedAt', 'deletedAt'];
    }

    /**
     * Retona um array com o nome das propriedade que o cliente pode setar para realizar o store
     * É usado principalmente em $this->setPropertiesEntity e nos Controllers.
     * Este método não evita que uma propriedade seja alterada caso tenha seu método set().
     *
     * @return array
     */
    abstract public function getOnlyStore();

    /**
     * Retona um array com o nome das propriedade que o cliente pode setar para realizar o update.
     * Por padrão retorna os mesmos valores de $this->getOnlyStore().
     * Este método pode ser sobrescrito nas classes filhas.
     * É usado principalmente em $this->setPropertiesEntity e nos Controllers.
     * Este método não evita que uma propriedade seja alterada caso tenha seu método set().
     *
     * @return array
     */
    public function getOnlyUpdate()
    {
        return $this->getOnlyStore();
    }

    final protected function checkOnyExceptInArray($key, array $options = null)
    {
        if (
            $options
            &&
            (
                (isset($options['only']) && is_array($options['only']) && !in_array($key, $options['only']))
                ||
                (isset($options['except']) && is_array($options['except']) && in_array($key, $options['except']))
            )
        ) {
            return false;
        }

        return true;
    }

    public function toArray(array $options = null)
    {
        $classMetadata = $this->getRepository()->getClassMetadata();
        $array = [];

        foreach ($this->getFillable() as $key) {
            if ($this->checkOnyExceptInArray($key, $options)) {
                if (is_object($this->$key) && $this->$key instanceof \DateTime || $this->$key instanceof \MongoTimestamp) {
                    $metaDataKey = $classMetadata->hasField($key) ? $classMetadata->getFieldMapping($key) : null;

                    if ($this->$key) {
                        $dateFormat = 'Y-m-d H:i:s';

                        if ($this->$key instanceof \MongoTimestamp) {
                            $timestamp = new \DateTime();
                            $timestamp->setTimestamp($this->$key->sec);
                            $this->$key = $timestamp;
                        }

                        $array[$key] = $this->$key->format($dateFormat);
                    }
                } elseif (is_object($this->$key) && $this->$key instanceof ArrayCollection || $this->$key instanceof PersistentCollection) {
                    $ids = [];
                    foreach ($this->$key->getValues() as $item) {
                        $ids[] = $item->getId();
                    }
                    $array[$key] = $ids;
                } elseif (method_exists($this->$key, 'getId')) {
                    $array[$key] = $this->$key->getId();
                } else {
                    $array[$key] = $this->$key;
                }
            }
        }

        return $array;
    }
}
