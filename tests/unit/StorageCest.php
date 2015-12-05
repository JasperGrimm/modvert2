<?php
use \UnitTester;

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
        $storage = new \Modvert\Storage();
        $I->assertTrue($storage instanceof \Modvert\Storage);
    }

    public function tryToLoadLocal(UnitTester $I)
    {
        $storage = new \Modvert\Storage();
        $storage->loadLocal();
    }
}
