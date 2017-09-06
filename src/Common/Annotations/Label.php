<?php

namespace Bludata\Common\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({
 *     "CLASS",
 *     "PROPERTY"
 * })
 */
class Label extends Annotation
{
    protected $exclusive = false;

    public function getLabel()
    {
        return $this->value;
    }

    public function isExclusive()
    {
        return $this->exclusive;
    }
}
