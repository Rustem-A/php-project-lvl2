<?php

namespace Differ\Renders;

// Подготавливаем массив под формат аккумулируя элементы по status
function json(array $arr): string
{
    // Аккумулятор
    $res = array_reduce($arr, function ($acc, $node) {
        switch ($node['status']) {
            case 'deleted':
                $acc[$node['key']] = [$node['status'], $node['beforeValue']];
                break;
            case 'added':
                $acc[$node['key']] = [$node['status'], $node['afterValue']];
                break;
            case 'same':
                $acc[$node['key']] = [$node['status'], $node['afterValue']];
                break;
            case 'nested':
                $acc[$node['key']] = json($node['children']);
                break;
            case 'changed':
                $acc[$node['key']] = [$node['status'], $node['beforeValue']];
                $acc[$node['key']] = [$node['status'], $node['afterValue']];
                break;
        }
        return $acc;
        // Массив
    }, []);
    
    // В строку
    $res = json_encode($res, JSON_PRETTY_PRINT | JSON_HEX_QUOT);

    // // Меняем символы под json
    $res = str_replace(['\n'], PHP_EOL, $res);
    $res = str_replace(['\u0022',], '"', $res);
    $res = str_replace(['[', ']'], ['{', '}'], $res);

    return $res;
}
