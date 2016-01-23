<?php

use Modvert\Driver\DatabaseDriver;
use Modvert\Application;
use Modvert\Resource\ResourceType;

class DatabaseDriverCest
{
    public function _before(UnitTester $I)
    {
      $app = Application::getInstance();
      $app->init();
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function tryToTest(UnitTester $I)
    {
        $driver = new DatabaseDriver($I->getConnection());
        dump($driver->truncate(ResourceType::CHUNK));
    }

    public function tryToGetLocks(UnitTester $I)
    {
        $driver = new DatabaseDriver($I->getConnection());
        $locks = $driver->getLocks();
        dump($locks);
    }

    public function tryToUnlock(UnitTester $I)
    {
        $driver = new DatabaseDriver($I->getConnection());
        $r = $driver->unlock();
    }

    public function testToTryTruncate(UnitTester $I)
    {
        /** @var PHPixie\Database\Connection $con */
        $con = $I->getConnection();

        $driver = new DatabaseDriver($con);
        $driver->truncate(ResourceType::CATEGORY);
        $con->insertQuery()
            ->table('modx_categories')
            ->data([
                'id'    => 1,
                'category' => 'Hello'
            ])->execute();

        $count = $con->countQuery()->table('modx_categories')->execute();

        $I->assertEquals(intval($count), 1);
    }
}
