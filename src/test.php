<?php

// function flatten($collection, $depth = 1)
// {
//     $result = [];

//     foreach ($collection as $value) {
//         if (is_array($value) && $depth > 0) {
//             $result = array_merge($result, flatten($value, $depth - 1));
//         } else {
//             $result[] = $value;
//         }
//     }

//     return $result;
// }

// function flattenAll($collection)
// {
//     $result = [];

//     foreach ($collection as $value) {
//         if (is_array($value)) {
//             $result = array_merge($result, flattenAll($value));
//         } else {
//             $result[] = $value;
//         }
//     }

//     return $result;
// }

// $file1 = json_decode(file_get_contents("../beforeTree.json"), true);
// $file2 = json_decode(file_get_contents("../afterTree.json"), true);

$file1 = json_decode(file_get_contents("../before.json"), true);
$file2 = json_decode(file_get_contents("../after.json"), true);
$keysFile1 = array_keys($file1);
$keysFile2 = array_keys($file2);
$unionKeys = array_unique(array_merge($keysFile1, $keysFile2));
//  Функциональный аналог поиска различий, принимает 2 плосих массива и
// их общие уникальные ключи
$reduce = array_reduce($unionKeys, function ($acc, $key) use ($file1, $file2) {
    if (array_key_exists($key, $file1) && array_key_exists($key, $file2) && $file1[$key] == $file2[$key]) {
        $acc["  $key"] = $file2[$key];
    } elseif (array_key_exists($key, $file1) && array_key_exists($key, $file2) && $file1[$key] != $file2[$key]) {
        $acc["- $key"] = $file1[$key];
        $acc["+ $key"] = $file2[$key];
    } elseif (!array_key_exists($key, $file2)) {
        $acc["- $key"] = $file1[$key];
    } elseif (!array_key_exists($key, $file1)) {
        $acc["+ $key"] = $file2[$key];
    }
    return $acc;
}, []);

print_r($reduce);
