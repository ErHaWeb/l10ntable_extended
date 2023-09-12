<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Extended Localization Table',
    'description' => 'With the assistance of this extension, the localization overview within the Info module gains an enhanced "Edit all language overlay records" button, featuring individually customizable fields. This empowers users to conveniently perform batch edits on configurable page fields on page translations.',
    'category' => 'module',
    'author' => 'Eric Harrer',
    'author_email' => 'info@eric-harrer.de',
    'author_company' => 'eric-harrer.de',
    'state' => 'experimental',
    'version' => '0.2.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-12.4.99',
            'info' => '11.5.0-12.4.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'ErHaWeb\\L10ntableExtended\\' => 'Classes',
        ],
    ],
];
