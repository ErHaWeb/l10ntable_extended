<?php

declare(strict_types=1);

use ErHaWeb\L10ntableExtended\Xclass\TranslationStatusController as TranslationStatusControllerXclass;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Info\Controller\TranslationStatusController;

defined('TYPO3') || die();

/**
 * Adding XCLASS for TranslationStatusController
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][TranslationStatusController::class] = [
    'className' => TranslationStatusControllerXclass::class,
];

if (GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion() < 13) {
    /**
     * Adding the default User TSconfig
     */
    ExtensionManagementUtility::addUserTSConfig('@import "EXT:l10ntable_extended/Configuration/user.tsconfig"');
}
