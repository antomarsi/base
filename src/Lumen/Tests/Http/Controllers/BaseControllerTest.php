<?php

namespace Bludata\Lumen\Tests\Http\Controllers;

use Bludata\Curl\Helpers\CurlHelper;
use Bludata\Lumen\Tests\BaseTest;

abstract class BaseControllerTest extends BaseTest
{
    protected $curlHelper;

    abstract public function getController();

    abstract public function getServiceTest();

    abstract public function getBaseRoute();

    public function createApplication()
    {
        $this->curlHelper = new CurlHelper(env('BASE_URL').$this->getBaseRoute(), ['Content-Type: application/json']);
    }
}
