<?php

namespace Differ;

// Получить различия файлов
function genDiff(string $filePath1, string $filePath2): string
{
    define("FILE1", getAssocArrayInJson($filePath1));
    define("FILE2", getAssocArrayInJson($filePath2));

    $res = array_merge(
        getSameElems(FILE1, FILE2),
        getChangedElems(FILE1, FILE2),
        getAddedElems(FILE1, FILE2),
        getDeletedElems(FILE1, FILE2)
    );
    
    $str = "";
    $str .= "{" . PHP_EOL;
    foreach ($res as $key => $value) {
        $str .= "$key: $value" . PHP_EOL;
    }
    $str .= "}" . PHP_EOL;
    return $str;
}
