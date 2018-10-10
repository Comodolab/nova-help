<?php

namespace Comodolab\Nova\Fields\Tests;

use Comodolab\Nova\Fields\Help\FieldServiceProvider;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();
        Route::middlewareGroup('nova', []);
    }
    protected function getPackageProviders($app)
    {
        return [
            FieldServiceProvider::class,
        ];
    }
}