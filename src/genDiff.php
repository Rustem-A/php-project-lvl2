<?php

namespace Differ;

use function Differ\Parsers\getAssocArray;

// Получить различия файлов
function genDiff(string $filePath1, string $filePath2): string
{
    // Отправляем на опред. расширения и выбор парсера, преоб. в массив
    $file1 = getAssocArray($filePath1);
    $file2 = getAssocArray($filePath2);

    // Получаем различия с помощью вспомогательных функций
    $deffArray = array_merge(
        // Опционально (описание в helpFunctions.php)
        getSameElems($file1, $file2),
        getChangedElems($file1, $file2),
        getAddedElems($file1, $file2),
        getDeletedElems($file1, $file2)
    );
    
    // Формируем результат в виде строки, возвращаем
    $str = "";
    $str .= "{" . PHP_EOL;
    foreach ($deffArray as $key => $value) {
        $str .= "$key: $value" . PHP_EOL;
    }
    $str .= "}" . PHP_EOL;
    return $str;
}
