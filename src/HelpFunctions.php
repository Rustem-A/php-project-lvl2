<?php

namespace Differ;

// Получить ассоц. массив из .json
function getAssocArrayInJson(string $pathToFile): array
{
    $jsonFromFile = file_get_contents($pathToFile, FILE_IGNORE_NEW_LINES);
    $jsonIntoArr = json_decode($jsonFromFile, true);
    return $jsonIntoArr;
}

// Получить неизмененные элементы из ассоц. массива
function getSameElems(array $arr1, array $arr2): array
{
    $res = [];
    foreach ($arr1 as $key => $value) {
        if (array_key_exists($key, $arr2) && $arr1[$key] == $arr2[$key]) {
            $res["  $key"] = $value;
        }
    }
    return $res;
}

// Получить измененные элементы из ассоц. массива
function getChangedElems(array $arr1, array $arr2): array
{
    $res = [];
    foreach ($arr1 as $key => $value) {
        if (array_key_exists($key, $arr2) && $arr1[$key] != $arr2[$key]) {
            $res["- $key"] = $value;
            $res["+ $key"] = $arr2[$key];
        }
    }
    return $res;
}

// Получить добавленые элементы
function getAddedElems(array $arr1, array $arr2): array
{
    $res = [];
    foreach ($arr2 as $key => $value) {
        if (!array_key_exists($key, $arr1)) {
            $res["+ $key"] = $value;
        }
    }
    return $res;
}

// Получить удаленые элементы
function getDeletedElems(array $arr1, array $arr2): array
{
    $res = [];
    foreach ($arr1 as $key => $value) {
        if (!array_key_exists($key, $arr2)) {
            $res["- $key"] = $value;
        }
    }
    return $res;
}
