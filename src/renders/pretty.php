<?php

namespace Differ\Renders;

function pretty(array $arr): string
{
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
    }, []);

    $res = json_encode($res, JSON_PRETTY_PRINT);

    $res = str_replace(['"', ','], '', $res);
    $res = str_replace(['\n'], PHP_EOL, $res);
    return $res;
}
