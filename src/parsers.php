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
    $fileExtension = strstr($pathToFile, '.');

    switch ($fileExtension) {
        case '.json':
            return JsonParser($pathToFile);
            break;
        case '.yml':
            return YmlParser($pathToFile);
            break;
    }
}
