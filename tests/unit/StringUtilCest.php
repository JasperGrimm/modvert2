<?php


class StringUtilCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function tryToTestTransliterate(UnitTester $I)
    {
        $str = 'Фото на странице ДР';
        $expected = 'Foto_na_stranice_DR';

        $str = \Modvert\StringUtil::transliterate($str);

        $I->assertEquals($expected, $str);
    }
}
