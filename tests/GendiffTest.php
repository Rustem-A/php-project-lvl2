<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Parsers\getAssocArray;
use function Differ\genDiff;
use function Differ\Renders\pretty;
use function Differ\Renders\plain;
use function Differ\Renders\json;

class GendiffTest extends TestCase
{
    public function testGenDiff()
    {
        $file1 = getAssocArray(__DIR__ . '/fixtures/beforeTree.json');
        $file2 = getAssocArray(__DIR__ . '/fixtures/afterTree.json');
        $expected = file_get_contents(__DIR__ . '/fixtures/expected/diffResult');

        $this->assertEquals($expected, json_encode(genDiff($file1, $file2), JSON_PRETTY_PRINT));
    }

    public function testPretty()
    {
        $file1 = getAssocArray(__DIR__ . '/fixtures/beforeTree.json');
        $file2 = getAssocArray(__DIR__ . '/fixtures/afterTree.json');
        $diff = genDiff($file1, $file2);
        $expected = file_get_contents(__DIR__ . '/fixtures/expected/prettyResult');

        $this->assertEquals($expected, pretty($diff));
    }

    public function testPlain()
    {
        $file1 = getAssocArray(__DIR__ . '/fixtures/beforeTree.json');
        $file2 = getAssocArray(__DIR__ . '/fixtures/afterTree.json');
        $diff = genDiff($file1, $file2);
        $expected = file_get_contents(__DIR__ . '/fixtures/expected/plainResult');

        $this->assertEquals($expected, plain($diff, ''));
    }

    public function testJson()
    {
        $file1 = getAssocArray(__DIR__ . '/fixtures/beforeTree.json');
        $file2 = getAssocArray(__DIR__ . '/fixtures/afterTree.json');
        $diff = genDiff($file1, $file2);
        $expected = file_get_contents(__DIR__ . '/fixtures/expected/jsonResult');

        $this->assertEquals($expected, json($diff));
    }
}
