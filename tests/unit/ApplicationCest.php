<?php

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
        $app->dump('test');
    }

    public function tryToLoadRemote(UnitTester $I)
    {
      $app = \Modvert\Application::getInstance();
      $app->loadRemote('test');
    }
}
