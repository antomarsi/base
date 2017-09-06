<?php

namespace Bludata\Doctrine\Common\Annotations\XML;

/**
 * @Annotation
 * @Target({"CLASS"})
 * @Attributes({
 *   @Attribute("name", type="string")
 * })
 */
class Entity extends XMLAnnotation
{
}
