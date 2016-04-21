<?php

use App\Services\Configuration;

class ConfigurationServiceCest
{
    protected $class;

    public function instantiateClass(UnitTester $I)
    {
        $app = $I->getApplication();
        $this->class = $app->make(Configuration::class);
    }

    public function clearAllServers(UnitTester $I)
    {
        $I->assertEquals(true, $this->class->clearServers());
    }

    public function seeNoServersRegistered(UnitTester $I)
    {
        $servers = $this->class->getServers();
        $I->assertEquals(is_array($servers), true);
        $I->assertEquals(count($servers), 0);
    }

    public function registerServer(UnitTester $I)
    {
        $server = array (
            'name' => 'My Beanstalkd Local Server',
            'ip'   => '10.15.20.1',
            'port' => '3304'
        );
        $I->assertEquals(true, $this->class->addServer($server));
    }

    public function assertServerPersists(UnitTester $I)
    {
        $servers = $this->class->getServers();
        $I->assertEquals(is_array($servers), true);
        $I->assertEquals(count($servers), 1);
        $I->assertEquals('My Beanstalkd Local Server', $servers[0]->name);
        $I->assertEquals('10.15.20.1', $servers[0]->ip);
        $I->assertEquals('3304', $servers[0]->port);
    }

    public function removeServer(UnitTester $I)
    {
        $server = $this->class->getServers()[0];
        $I->assertEquals(true, $this->class->removeServer($server->id));
        $servers = $this->class->getservers();
        $I->assertEquals(count($servers), 0);
    }
}
