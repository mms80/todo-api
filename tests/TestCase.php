<?php

namespace mms80\TodoApi\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use mms80\TodoApi\TodoApiServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app
        ->make(EloquentFactory::class)
        ->load(__DIR__.'/../database/factories');
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations(["--database" => "testbench"]);

        // call migrations specific to our tests, e.g. to seed the db
        // the path option should be an absolute path.
        $this->loadMigrationsFrom([
            "--database" => "testbench",
            "--path" => realpath(__DIR__ . "/../database/migrations"),
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [TodoApiServiceProvider::class];
    }

    protected function resolveApplicationCore($app)
    {
        parent::resolveApplicationCore($app);

        $app->detectEnvironment(function () {
            return "self-testing";
        });
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $config = $app->get("config");

        $config->set("logging.default", "errorlog");

        $config->set("database.default", "testbench");

        $config->set("telescope.storage.database.connection", "testbench");

        $config->set("database.connections.testbench", [
            "driver" => "sqlite",
            "database" => ":memory:",
            "prefix" => "",
        ]);

        $app->when(DatabaseEntriesRepository::class)
            ->needs('$connection')
            ->give("testbench");
    }

}
