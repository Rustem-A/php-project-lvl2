<?php

namespace Differ;

use function Differ\Parsers\getAssocArray;
use function Differ\Renders\pretty;

function genDiff(array $fileBefore, array $fileAfter): array
{
      // Создаем узел из которых формируется предварительный массив
    $makeNode = function ($status, $key, $beforeValue, $afterValue, $children): array {
        return [
              'status' => $status,
              'key' => $key,
              'beforeValue' => $beforeValue,
              'afterValue' => $afterValue,
              'children' => $children
          ];
    };
      // Находим общие уник. ключи по которым фильтруем элементы при записи в новую ноду
            $keysFile1 = array_keys($fileBefore);
            $keysFile2 = array_keys($fileAfter);
            $unionKeys = array_unique(array_merge($keysFile1, $keysFile2));

      /* Перебераем все уник. ключи подставляя по ключу в исходные массивы. Каждую
      *  итерацию map записывает в новый массив ноду созданную по фильтрам повторяя
      *  конструкцию исходных массивов
      */
      return array_map(function ($key) use ($fileBefore, $fileAfter, $makeNode) {
        if (!array_key_exists($key, $fileBefore)) {
            return $makeNode('added', $key, false, $fileAfter[$key], false);
        }
        if (!array_key_exists($key, $fileAfter)) {
            return $makeNode('deleted', $key, $fileBefore[$key], false, false);
        }
        if ($fileBefore[$key] === $fileAfter[$key]) {
            return $makeNode('same', $key, $fileBefore[$key], $fileAfter[$key], false);
        }
        // рекурсия в глубину массива
        if (is_array($fileBefore[$key]) && is_array($fileAfter[$key])) {
            return $makeNode('nested', $key, false, false, genDiff($fileBefore[$key], $fileAfter[$key]));
        }
        if ($fileBefore[$key] !== $fileAfter[$key]) {
            return $makeNode('changed', $key, $fileBefore[$key], $fileAfter[$key], false);
        }
      }, $unionKeys);
}
