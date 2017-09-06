<?php

namespace Bludata\Doctrine\Common\Converters;

abstract class Converter
{
    abstract public function toString($element);
}
