<?php

class StorageCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function tryToCreateStorage(UnitTester $I)
    {
        $storage = new \Modvert\Storage($I->getConnection());
        $I->assertTrue($storage instanceof \Modvert\Storage);
    }

    public function tryToLoadLocal(UnitTester $I)
    {
        $storage = new \Modvert\Storage($I->getConnection());
        $storage->loadLocal();
    }

    public function tryToBuildFromFiles(UnitTester $I)
    {
        //$storage = new \Modvert\Storage($I->getConnection());
        //$storage->buildFromFiles();
    }
}
