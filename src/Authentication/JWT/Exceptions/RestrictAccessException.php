<?php

namespace Bludata\Authentication\JWT\Exceptions;

final class RestrictAccessException extends \Exception
{
    protected $message = 'Área restrita! Efetue o login antes de continuar.';
}
