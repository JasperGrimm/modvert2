<?php


class ResourceTypeCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function tryToTest(UnitTester $I)
    {
        $path = 'storage/chunk/test_chunk.model';
        $I->assertTrue(\Modvert\Resource\ResourceType::CHUNK === \Modvert\Resource\ResourceType::fromPath($path));
        $path = 'storage/snippet/test_chunk.model';
        $I->assertTrue(\Modvert\Resource\ResourceType::SNIPPET === \Modvert\Resource\ResourceType::fromPath($path));
        $path = 'storage/template/test_chunk.model';
        $I->assertTrue(\Modvert\Resource\ResourceType::TEMPLATE === \Modvert\Resource\ResourceType::fromPath($path));
        $path = 'storage/templatebird/test_chunk.model';
        $I->assertNull(\Modvert\Resource\ResourceType::fromPath($path));

    }
}
