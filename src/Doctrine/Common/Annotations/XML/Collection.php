<?php

namespace Bludata\Doctrine\Common\Annotations\XML;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 * @Attributes({
 *   @Attribute("name", type="string"),
 *   @Attribute("reference", type="string")
 * })
 */
class Collection extends XMLAnnotation
{
    protected $reference;
}
