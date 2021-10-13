<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PHP74Migration' => true,
        '@PHP74Migration:risky' => true,

        /*
         * CUSTOM
         */
        'final_class' => true,
        'final_public_method_for_abstract_class' => true,
        'no_unneeded_final_method' => true,
        'self_static_accessor' => true,
        'method_chaining_indentation' => true,
        'no_superfluous_phpdoc_tags' => false,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'not_operator_with_space' => false,
        'not_operator_with_successor_space' => false,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_no_empty_return' => false,
        'phpdoc_separation' => true,
        'phpdoc_trim' => true,
        'phpdoc_no_useless_inheritdoc' => true,
        'phpdoc_to_comment' => false,
        'return_assignment' => true,
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
            'less_and_greater' => false,
        ],
        'concat_space' => [
            'spacing' => 'one',
        ],
        'declare_strict_types' => true,
    ])
    ->setFinder($finder)
;
