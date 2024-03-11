<?php

declare(strict_types=1);

use ErHaWeb\L10ntableExtended\Xclass\TranslationStatusController as TranslationStatusControllerXclass;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Info\Controller\TranslationStatusController;

defined('TYPO3') || die();

/**
 * Adding XCLASS for TranslationStatusController
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][TranslationStatusController::class] = [
    'className' => TranslationStatusControllerXclass::class,
];

/**
 * Adding the default User TSconfig
 */
ExtensionManagementUtility::addUserTSConfig('
@import "EXT:l10ntable_extended/Configuration/TsConfig/User/default.tsconfig"
');
