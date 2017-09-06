<?php

use Bludata\Doctrine\Common\Annotations\XML\Entity;
use Bludata\Doctrine\Common\Annotations\XML\Field;
use Bludata\Common\Traits\AttributesTrait;

/**
 * @Bludata\Doctrine\Common\Annotations\XML\Entity(name="foo")
 */
class PropertyAnnotationStub
{
    use AttributesTrait;

    /**
     * @Bludata\Doctrine\Common\Annotations\XML\Field(name="bar")
     */
    protected $property;
}
