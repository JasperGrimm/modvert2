<?php
use \UnitTester;

class ApplicationCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function tryToSync(UnitTester $I)
    {
        $app = \Modvert\Application::getInstance();
        $app->sync('test');
    }
}
