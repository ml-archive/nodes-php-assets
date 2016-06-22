<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Nodes\Assets\ServiceProvider;

class RolesRepositoryTest extends Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->assertTrue(true);
        $this->assertTrue(true);
    }
}
