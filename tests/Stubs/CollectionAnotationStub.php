<?php

use Bludata\Doctrine\Common\Annotations\XML\Entity;
use Bludata\Doctrine\Common\Annotations\XML\Field;
use Bludata\Common\Traits\AttributesTrait;

/**
 * @Bludata\Doctrine\Common\Annotations\XML\Entity(name="foo")
 */
class CollectionAnnotationStub
{
    use AttributesTrait;

    /**
     * @Bludata\Doctrine\Common\Annotations\XML\Field(name="bar")
     */
    protected $property;

    /**
     * @Bludata\Doctrine\Common\Annotations\XML\Collection(name="collection", reference="\PropertyAnnotationStub")
     */
    protected $collection;
}
