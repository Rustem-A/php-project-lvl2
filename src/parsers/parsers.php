<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

// Парсер (ассоц. массив из .json)
function JsonParser(string $pathToFile): array
{
    $jsonFromFile = file_get_contents($pathToFile, FILE_IGNORE_NEW_LINES);
    $jsonIntoArr = json_decode($jsonFromFile, true);
    return $jsonIntoArr;
}
// Парсер (ассоц. массив из .yml)
function YmlParser(string $pathToFile): array
{
    return Yaml::parseFile($pathToFile);
}
// Выбирается функция-парсер в зависимости от расширения файла
function getAssocArray(string $pathToFile): array
{
    // Исключение
    if (!is_readable($pathToFile)) {
        throw new \Exception("'{$pathToFile}' is not readble");
    }

    $fileExtension = substr(strrchr($pathToFile, "."), 1);

    switch ($fileExtension) {
        case 'json':
            return JsonParser($pathToFile);
            break;
        case 'yaml':
        case 'yml':
            return YmlParser($pathToFile);
            break;
    }
}
