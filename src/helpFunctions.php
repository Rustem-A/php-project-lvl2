<?php

namespace Differ;

// Для плоских массивов, пара (ключ-элемент)
 
// Получить неизмененные элементы из ассоц. массивов
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

// Получить измененные элементы из ассоц. массивов
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
