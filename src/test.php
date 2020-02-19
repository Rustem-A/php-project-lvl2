<?php

// Получить различия файлов
function genDiff($fileBefore, $fileAfter)
{
      // Создаем узел из которых формируется предварительный массив
    function makeNode($status, $key, $beforeValue, $afterValue, $children)
    {
            return [
            'status' => $status,
            'key' => $key,
            'beforeValue' => $beforeValue,
            'afterValue' => $afterValue,
            'children' => $children
            ];
    }
      // Находим общие уник. ключи по которым фильтруем элементы при записи в новую ноду
      $keysFile1 = array_keys($fileBefore);
      $keysFile2 = array_keys($fileAfter);
      $unionKeys = array_unique(array_merge($keysFile1, $keysFile2));

      /* Перебераем все уник. ключи подставляя по ключу в исходные массивы. Каждую
      *  итерацию map записывает в новый массив ноду созданную по фильтрам повторяя
      *  конструкцию исходных массивов
      */
      return array_map(function ($key) use ($fileBefore, $fileAfter) {
        if (!array_key_exists($key, $fileAfter)) {
            return makeNode('Deleted', $key, $fileBefore[$key], null, null);
        }
        if (!array_key_exists($key, $fileBefore)) {
            return makeNode('Added', $key, null, $fileAfter[$key], null);
        }
        if ($fileBefore[$key] != $fileAfter[$key]) {
            return makeNode('Changed', $key, $fileBefore[$key], $fileAfter[$key], null);
        }
        if ($fileBefore[$key] == $fileAfter[$key]) {
            return makeNode('Same', $key, $fileBefore[$key], $fileAfter[$key], null);
        }
        // Рукурсия в глубину массива если значение по ключу - массив
        if (is_array($fileBefore[$key]) && is_array($fileAfter[$key])) {
            return makeNode('Child', $key, null, null, genDiff($fileBefore[$key], $fileAfter[$key]));
        }
      }, $unionKeys);
}
