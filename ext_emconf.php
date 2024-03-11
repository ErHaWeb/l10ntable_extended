<?php

/**
 * This file is part of the "l10ntable_extended" Extension for TYPO3 CMS.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Extended Localization Table',
    'description' => 'With the assistance of this extension, the localization overview within the Info module gains an enhanced "Edit all language overlay records" button, featuring individually customizable fields. This empowers users to conveniently perform batch edits on configurable page fields on page translations.',
    'category' => 'module',
    'author' => 'Eric Harrer',
    'author_email' => 'info@eric-harrer.de',
    'author_company' => 'eric-harrer.de',
    'state' => 'experimental',
    'clearCacheOnLoad' => true,
    'version' => '0.3.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-12.4.99',
            'info' => '11.5.0-12.4.99',
            'php' => '7.4.0-8.3.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'ErHaWeb\\L10ntableExtended\\' => 'Classes',
        ],
    ],
];
