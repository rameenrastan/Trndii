<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Bart\Ab\Ab;
use App\Domain\ExperimentHandler;
use Mockery;
use Log;

class UserSegmentAssignmentTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Tests that a user is assigned to a proper segment for A/B testing
     *
     * @return void
     */
    public function testExample()
    {
        putenv('DB_CONNECTION=sqlite_testing');

        $user = factory(\App\User::class)->make();

        $mockExperimentsRepo = Mockery::mock('App\Repositories\ExperimentsRepository');
        $mockExperimentsRepo->shouldReceive('incrementExperimentAPopulation');
        $mockExperimentsRepo->shouldReceive('incrementExperimentBPopulation');

        Log::shouldReceive('info');
        $ab = new Ab;
        $experimentHandler = new ExperimentHandler(new Log, $ab, $mockExperimentsRepo);

        $experimentHandler->handleExperiment($user, "");

        $this->assertTrue($user->segment == "Token" || $user->segment == "Basic");
    }
}
