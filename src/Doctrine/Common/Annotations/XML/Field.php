<?php

namespace Bludata\Doctrine\Common\Annotations\XML;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 * @Attributes({
 *   @Attribute("name", type="string")
 * })
 */
class Field extends XMLAnnotation
{
}
