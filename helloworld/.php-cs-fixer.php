<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude('vendor');

return (new Config())
    ->setRules([
        '@PSR12' => true,
        // 아래는 PSR-12에 없는 but 추천되는 옵션들
        'indentation_type' => true, // 들여쓰기 스페이스 사용
        'method_chaining_indentation' => true, // 메서드 체이닝 들여쓰기
        'single_quote' => true, // 문자열 단일 쿼터(single quote) 사용
        'array_syntax' => ['syntax' => 'short'], // [] 배열 문법 강제
    ])
    ->setFinder($finder)
    ->setIndent('    ') // 4 spaces
;
