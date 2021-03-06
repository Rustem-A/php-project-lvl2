<?php

namespace Differ\Renders;

function toString($arr)
{
    $res = '';
    foreach ($arr as $key => $value) {
        $res .= "'$key: $value' ";
    }
    return $res;
}

function plain(array $arr, $path): string
{
    // Аккумулятор
    $res = array_reduce($arr, function ($acc, $node) use ($path) {

        // Формируем путь по вложенности массива
        $path .= $node['key'] . ".";

        // Плоский массив -> строка
        if (is_array($node['afterValue'])) {
            $newValue = toString($node['afterValue']);
        } else {
            $newValue = $node['afterValue'];
        }

        // Строковый вывод
        switch ($node['status']) {
            case 'deleted':
                $acc .= "Property '$path' was deleted" . PHP_EOL;
                break;
            case 'added':
                $acc .= "Property '$path' was added whith value: $newValue" . PHP_EOL;
                break;
                // Рекурсия
            case 'nested':
                $acc .= plain($node['children'], $path);
                break;
            case 'changed':
                $acc .= "Property '$path' was changed. From: '$node[beforeValue]' to: '$node[afterValue]'" . PHP_EOL;
                break;
        }
        return $acc;
        // Строка
    }, '');

    return $res;
}
