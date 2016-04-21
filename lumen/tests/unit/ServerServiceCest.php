<?php

use App\Services\Server;
use Faker\Factory as Faker;

class ServerServiceCest
{
    protected $class;
    protected $faker;

    public function instantiateClass(UnitTester $I)
    {
        $this->class = new Server('127.0.0.1', '11300');
        $this->faker = Faker::create();
    }

    public function probeServer(UnitTester $I)
    {
        $I->assertEquals(true, $this->class->probeServer());
    }

    public function listTubes(UnitTester $I)
    {
        $tubes = $this->class->listTubes();
        $I->assertEquals(is_array($tubes), true);
    }

    public function seeCreatedTube(UnitTester $I)
    {
        $tubeName = $this->faker->slug();
        $job = $this->class->putInTube($tubeName, 'bogus-data');
        $I->assertEquals(is_numeric($job), true);
        $tubes = collect($this->class->listTubes());
        $I->assertEquals(true, is_numeric($tubes->search($tubeName)));
    }

    public function getTubeStats(UnitTester $I)
    {
        $tubeName = $this->faker->slug();
        $job = $this->class->putInTube($tubeName, 'bogus-data');
        $I->assertEquals(is_numeric($job), true);
        $stats = $this->class->statsTube($tubeName);
        $I->assertEquals($stats['total-jobs'], 1);
    }

    public function getServerStats(UnitTester $I)
    {
        $stats = $this->class->stats();
        $I->assertEquals(1, $stats['current-connections']);
    }
}
