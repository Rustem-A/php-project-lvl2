<?php

namespace Differ\Renders;

// Подготавливаем массив под формат аккумулируя элементы по status
function pretty(array $arr): string
{
    // Аккумулятор
    $res = array_reduce($arr, function ($acc, $node) {
        switch ($node['status']) {
            case 'deleted':
                $acc["- " . $node['key']] = $node['beforeValue'];
                break;
            case 'added':
                $acc["+ " . $node['key']] = $node['afterValue'];
                break;
            case 'same':
                $acc["  " . $node['key']] = $node['afterValue'];
                break;
            case 'nested':
                $acc[$node['key']] = pretty($node['children']);
                break;
            case 'changed':
                $acc["- " . $node['key']] = $node['beforeValue'];
                $acc["+ " . $node['key']] = $node['afterValue'];
                break;
        }
        return $acc;
        // Массив
    }, []);
    
    // В строку
    $res = json_encode($res, JSON_PRETTY_PRINT);

    // Меняем символы под pretty
    $res = str_replace(['"', ','], '', $res);
    $res = str_replace(['\n'], PHP_EOL, $res);
    return $res;
}
