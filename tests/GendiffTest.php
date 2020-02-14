<?php

namespace Differ;

use PHPUnit\Framework\TestCase;

// НЕ РАБОТАЕТ!
// use function Differ\Gendiff\genDiff;

require_once "src/Gendiff.php";

require_once "src/HelpFunctions.php";

class GendiffTest extends TestCase
{
    public function testGenDiff()
    {
        $file1 = __DIR__ . '/fixtures/testBefore.json';
        $file2 = __DIR__ . '/fixtures/testAfter.json';
        
        $expect = '{
  host: hexlet.io
- timeout: 50
+ timeout: 20
+ verbose: 1
- proxy: 123.234.53.22
}' . PHP_EOL;

        $this->assertEquals($expect, genDiff($file1, $file2));
    }
}
