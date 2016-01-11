<?php
use Modvert\Helper\ArrayHelper;

class ArrayHelperCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function tryToTestGetSingular(UnitTester $I)
    {
        $array = [
          'key_level_1' => [
            'key_level_2' =>'data_1_2'
          ]
        ];

        $expected = "data_1_2";

        $I->assertEquals($expected, \Modvert\Helper\ArrayHelper::get($array, 'key_level_1.key_level_2'));
    }

    public function tryToTestGetArray(UnitTester $I)
    {
        $array = [
          'key_level_1' => [
            'key_level_2' => [
              'data_1_2',
              'mix',
              'fix'
            ]
          ]
        ];

        $expected = ["data_1_2","mix","fix"];

        $I->assertEquals($expected, \Modvert\Helper\ArrayHelper::get($array, 'key_level_1.key_level_2'));
    }

    public function tryToTestPluck(UnitTester $I)
    {
      $array = [
        0 => [
          "file" => "bin/modvert.web.php",
          "index" => " ",
          "work_tree" => "M"
        ],
        1 => [
          "file" => "src/Modvert/Application.php",
          "index" => " ",
          "work_tree" => "M"
        ],
        2 => [
          "file" => "tests/unit/ApplicationCest.php",
          "index" => " ",
          "work_tree" => "M"
        ]
      ];
      $expected = [
        'bin/modvert.web.php',
        'src/Modvert/Application.php',
        'tests/unit/ApplicationCest.php'
      ];
      $I->assertEquals($expected, ArrayHelper::pluck($array, 'file'));
    }

    public function tryToMatchValue(UnitTester $I)
    {
      $array = [
        0 => [
          "file" => "bin/modvert.web.php",
          "index" => " ",
          "work_tree" => "M"
        ],
        1 => [
          "file" => "src/Modvert/Application.php",
          "index" => " ",
          "work_tree" => "M"
        ],
        2 => [
          "file" => "tests/unit/ApplicationCest.php",
          "index" => " ",
          "work_tree" => "M"
        ],
        3 => [
          "file" => "src/Modvert/Helper/Git.php",
          "index" => " ",
          "work_tree" => "M"
        ],
      ];
      $expected = [
        'src/Modvert/Application.php',
        'src/Modvert/Helper/Git.php'
      ];
      $I->assertEquals($expected, ArrayHelper::matchValue($array, 'file', '/^src/'));
    }
}
