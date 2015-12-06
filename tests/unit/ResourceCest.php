<?php

class ResourceCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function tryToCreateNewChunk(UnitTester $I)
    {
        $data = [
            'id' => 1,
            'name' => 'HEADER',
            'description' => 'header stripe for main_site pages',
            'snippet' => '<header>Header stripe</header>'
        ];
        $r = new \Modvert\Resource\Modx\Chunk($data);
        $I->assertEquals(1, $r->getId());
        $I->assertEquals(\Modvert\Resource\ResourceType::CHUNK, $r->getType());
        $I->assertEquals('HEADER', $r->getName());
        $I->assertEquals($data, $r->getCleanFields());
    }

    public function tryToCompareIdenticalChunks(UnitTester $I)
    {
        /** @var \Modvert\Resource\Modx\Chunk $r1 */
        /** @var \Modvert\Resource\Modx\Chunk $r2 */
        $r1 = $I->createChunk();
        $r2 = $I->createChunk();
        $ch = \Modvert\Comparator\ComparatorFactory::get(\Modvert\Resource\ResourceType::CHUNK)
            ->compare($r1, $r2);
        $I->assertFalse($ch);
    }

    public function tryToCompareDifferentChunks(UnitTester $I)
    {
        /** @var \Modvert\Resource\Modx\Chunk $r1 */
        /** @var \Modvert\Resource\Modx\Chunk $r2 */
        $r1 = $I->createChunk();
        $r2 = $I->createChunk();
        $d2 = $r2->getData();
        $d2['snippet'] = '<header>Another header stripe</header>';
        $r2->setData($d2);

        $ch = \Modvert\Comparator\ComparatorFactory::get(\Modvert\Resource\ResourceType::CHUNK)
            ->compare($r1, $r2);
        $I->assertTrue($ch);
    }
}
