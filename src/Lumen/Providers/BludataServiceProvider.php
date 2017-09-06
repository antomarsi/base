<?php

namespace Bludata\Lumen\Providers;

use Bludata\Lumen\Authentication\JWT\Providers\JWTServiceProvider;
use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\Extensions\GedmoExtensionsServiceProvider;
use LaravelDoctrine\Migrations\MigrationsServiceProvider;
use LaravelDoctrine\ORM\DoctrineServiceProvider;
use LaravelDoctrine\ORM\Facades\Doctrine;
use LaravelDoctrine\ORM\Facades\EntityManager;
use LaravelDoctrine\ORM\Facades\Registry;

class BludataServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(MigrationsServiceProvider::class);
        $this->app->register(DoctrineServiceProvider::class);
        $this->app->register(GedmoExtensionsServiceProvider::class);

        $this->app->register(JWTServiceProvider::class);
        $this->app->register(CustomConnectionSqlanywhereServiceProvider::class);
        $this->app->register(RegisterCustomAnnotationsServiceProvider::class);

        class_alias(EntityManager::class, 'EntityManager');
        class_alias(Registry::class, 'Registry');
        class_alias(Doctrine::class, 'Doctrine');
    }
}
