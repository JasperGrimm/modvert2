<?php


class FilesystemHelperCest
{
    private $test_tree;

    public function _before(UnitTester $I)
    {
        $this->test_tree = TARGET_PATH . DIRECTORY_SEPARATOR . 'storage';
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function tryToTest(UnitTester $I)
    {
        $this->createTree($this->test_tree);
        Modvert\Filesystem\Helper::delTree($this->test_tree . DIRECTORY_SEPARATOR . 'test', ['.gitignore']);
    }

    private function createTree($root)
    {
        $test_storage = $root . DIRECTORY_SEPARATOR . 'test';
        @mkdir($test_storage);
        $f = fopen($test_storage . DIRECTORY_SEPARATOR . 'sample.model', 'w');
        fclose($f);
    }
}
